import mysql.connector
import bcrypt
from flask import Flask, render_template, request, jsonify, session
from flask_session import Session
from flask_cors import CORS
from email_validator import validate_email, EmailNotValidError
from datetime import datetime

app = Flask(__name__)
CORS(app)

app.config["SESSION_PERMANENT"] = False
app.config["SESSION_TYPE"] = "filesystem"

Session(app)

db = {
    'host': "localhost",
    'user': "root",
    'password': "",
    'database': "jobposting"
}


SortBy = {
    "date": "jv.`date_created`",
    "salary_min": "sb.`min`",
    "salary_max": "sb.`max`",
    "job_title": "ji.`job_title`"
}

roles = {
    "admin": 0,
    "employer": 1,
    "jobseeker": 2,
}

tags_list = [
        "job_title",
        "job_category",
        "industry",
        "employment_type",
        "salary",
        "skill",
        "min_proficiency",
        "district",
        "country",
        "cityprovince",
        "min_degree_level",
        "min_experience_years"
    ]

@app.route('/home', methods=['POST'])
def fetch_all_post_cards():
    cursor = None
    connection = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Filtering and fetching all posts...")

        data = request.get_json() or {}

        keyword = data.get("keyword", "")
        category = data.get("job_category", "")
        country = data.get("country", "")
        cityprovince = data.get("cityprovince", "")
        skills = data.get("skills", [])
        employment_type = data.get("employment_type", "")
        job_level = data.get("job_level", "")
        salary_min = data.get("salary", {}).get("min", 0)
        salary_max = data.get("salary", {}).get("max", 0)
        work_arrangement = data.get("work_arrangement", "")
        sort_by = data.get("sort", {}).get("by", "")
        order = data.get("sort", {}).get("order", "asc")

        filters=[]
        params=[]
        where_clause = ""
        sort_clause = ""
        

        if keyword:
            filters.append("(ji.`job_title` like %s or jv.`job_responsibilities` like %s or jv.`required_qualifications` like %s or jv.`preferred_skills` like %s or jv.`notes` like %s)")
            params.extend([f"%{keyword}%"] * 5)

        if category:
            filters.append("ji.`job_category` = %s")
            params.append(category)

        if country:
            filters.append("jl.`country` = %s")
            params.append(country)

        if cityprovince:
            filters.append("jl.`cityprovince` = %s")
            params.append(cityprovince)

        if skills:
            placeholder = ",".join(["%s"] * len(skills))
            filters.append(f"exists (select 1 from `required_skills` as rs where rs.`job_id` = jv.`job_id` and rs.`skill` in ({placeholder}))")
            params.extend(skills)

        if employment_type:
            filters.append("ji.`employment_type` = %s")
            params.append(employment_type)

        if job_level:
            filters.append("ji.`job_level` = %s")
            params.append(job_level)
        
        if salary_min > 0:
            filters.append("sb.`min` > %s")
            params.append(salary_min)
        
        if salary_max > 0:
            filters.append("sb.`max` < %s")
            params.append(salary_max)
        
        if work_arrangement:
            filters.append("jl.`work_arrangement` = %s")
            params.append(work_arrangement)

        if sort_by:
            sort_column = SortBy.get(sort_by, "jv.`date_created`")
            sort_order = "ASC" if order.lower() == "asc" else "DESC"
            sort_clause = f"order by {sort_column} {sort_order}"


        where_clause = "where " + " and ".join(filters) if filters else ""

        sql = f"""select
        jv.`job_id` as `id`,
        ji.`job_title` as `job_title`,
        ji.`industry` as `industry`,
        ji.`job_level` as `job_level`,
        jl.`work_arrangement` as `work_arrangement`,
        sb.`min` as `salary_min`,
        sb.`max` as `salary_max`,
        jv.`date_created` as `date_created`
        from `job_information` as ji
        join `job_vacancy` as jv on jv.`job_id` = ji.`job_id`
        join `job_location` as jl on jv.`job_id` = jl.`job_id`
        join `salary_benefits` as sb on jv.`job_id` = sb.`job_id`
        {where_clause}
        {sort_clause}
        """

        cursor.execute(sql, params)

        cards = cursor.fetchall()
        ret = jsonify(cards), 200
        print(cards)
        return ret
    except mysql.connector.Error as db_err:
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/login", methods=['POST'])
def login():
    if session.get("email"):
        return jsonify({'msg': "User is already logged in"}), 400

    connection = None
    cursor = None
    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Logging in")

        data = request.get_json() or {}

        email = data.get("email")
        password = data.get("password")
        role = data.get("role")

        if not email:
            raise Exception("No email provided")
        if not password:
            raise Exception("No password provided")
        if not role:
            raise Exception("No role provided (how)")
        
        emailinfo = validate_email(email)
        email_norm = emailinfo.normalized

        role_id = roles.get(role)

        if role_id is None:
            raise Exception("Invalid role")
        
        sql = "select `password` from `user` where `email` = %s and `role` = %s"

        cursor.execute(sql, [email_norm, role_id])

        sql_data = cursor.fetchone()

        if sql_data is None:
            return jsonify({'error': 'User not found'}), 401
        else:
            hashed_pwd = sql_data.get("password") # type: ignore

        pwd_bytes = password.encode('utf-8')
        hashed_pwd_bytes = hashed_pwd.encode('utf-8') # type: ignore
        if not bcrypt.checkpw(pwd_bytes, hashed_pwd): # type: ignore
            return jsonify({'error': 'Wrong password'}), 401

        session["email"] = email_norm
        session["role"] = role_id

        return jsonify({'msg': "User is logged in", 'email': email, 'role': role}), 200

    except mysql.connector.Error as db_err:
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except EmailNotValidError as e:
        return jsonify({'error': "Invalid email"}), 400
    except Exception as e:
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/logout", methods=['POST'])
def logout():
    if not session.get("email"):
        return jsonify({'msg': "No users to log out"}), 400
    try:
        print("Logging out...")

        session.pop("email", None)
        session.pop("role", None)
        
        return jsonify({'msg': "User logged out"}), 200
    except Exception as e:
        return jsonify({'error': f'Error: {str(e)}'}), 500

@app.route("/register", methods=['POST'])
def register():
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Registering")

        data = request.get_json() or {}

        email = data.get("email")
        password = data.get("password")
        role = data.get("role")
        name = data.get("name")

        if not (email and password and role and name):
            return jsonify({'err': "Missing data"}), 400

        if len(password) < 8:
            return jsonify({'err': "Password should be at least 8 characters"}), 400

        emailinfo = validate_email(email)
        email_norm = emailinfo.normalized

        role_id = roles.get(role)

        if role_id is None:
            return jsonify({'err': "Invalid role"}), 400
        
        sql1 = "select * from `user` where `email` = %s"

        cursor.execute(sql1, [email_norm, role_id])

        if cursor.rowcount != 0:
            return jsonify({'err': "The email already exists"}), 400
        
        pwd_bytes = password.encode('utf-8')
        salt = bcrypt.gensalt()

        hashed_pwd_bytes = bcrypt.hashpw(pwd_bytes, salt)

        hashed_pwd = hashed_pwd_bytes.decode('utf-8')

        sql2 = "insert into `user`(`email`, `password`, `name`, `role`) values (%s, %s, %s, %s)"
        
        cursor.execute(sql2, [email_norm, hashed_pwd, name, role_id])
        
        connection.commit()

        # Also logs in
        session["email"] = email_norm
        session["role"] = role_id

        return jsonify({'msg': "User registered", 'email': email, 'role': role, 'name': name}), 200
    except mysql.connector.Error as db_err:
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except EmailNotValidError as e:
        return jsonify({'error': "Invalid email"}), 400
    except Exception as e:
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/jobs/<int:job_id>", methods=['GET'])
def get_job_details(job_id):
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") not in [roles["jobseeker"], roles["admin"]]:
        return jsonify({'msg': "Only jobseekers and admins can use this"}), 403
    
    connection = None
    cursor = None
    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Fetching job vacancy details...")
        
        sql = """
select
jv.*,
ji.employment_type,
ji.job_title,
ji.job_category,
ji.industry,
ji.job_level,
ji.opening_count,
jl.country,
jl.district,
jl.cityprovince,
jl.work_arrangement,
re.min_degree_level,
re.min_experience_years,
sb.min as salary_min,
sb.max as salary_max,
sb.type as salary_type,
sb.benefits
from job_information ji
join job_location jl on ji.job_id = jl.job_id
join job_vacancy jv on jl.job_id = jv.job_id
join required_education_experience re on re.job_id = jv.job_id
join salary_benefits sb on sb.job_id = jv.job_id
where jv.job_id = %s
"""

        cursor.execute(sql, [job_id])

        details = cursor.fetchone()

        if details is None:
            return jsonify({'error': f"No job with ID {job_id} found in database"}), 404

        sql2 = "select skill, min_proficiency from required_skills where job_id = %s"

        cursor.execute(sql2, [job_id])

        skills = cursor.fetchall()

        return jsonify({'details': details, 'skills': skills}), 200

    except mysql.connector.Error as db_err:
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/new_job_vacancy", methods=['POST'])
def create_job_vacancy():
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") != roles["employer"]:
        return jsonify({'msg': "Only employers can view this page"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Creating a new job vacancy")

        data = request.get_json() or {}

        email = session.get("email")

        job_title = data.get("basic_info", {}).get("job_title")
        job_category = data.get("basic_info", {}).get("job_category")
        employment_type = data.get("basic_info", {}).get("employment_type")
        industry = data.get("basic_info", {}).get("industry")
        job_level = data.get("basic_info", {}).get("job_level")
        opening_count = data.get("basic_info", {}).get("opening_count")

        country = data.get("location", {}).get("country")
        city = data.get("location", {}).get("city")
        district = data.get("location", {}).get("district", "")
        work_arrangement = data.get("location", {}).get("work_arrangement")

        salary_min = data.get("wages", {}).get("salary", {}).get("min")
        salary_max = data.get("wages", {}).get("salary", {}).get("max")
        salary_type = data.get("wages", {}).get("type")
        benefits = data.get("wages", {}).get("benefits", "")

        responsibilities = data.get("description", {}).get("responsibilities", "")
        qualifications = data.get("description", {}).get("qualifications", "")
        preferred_skills = data.get("description", {}).get("preferred_skills", "")
        notes = data.get("description", {}).get("notes", "")
        date = datetime.now()
        mysql_date = date.strftime("%Y-%m-%d")

        skills = data.get("requirements", {}).get("skills", [])  # Ideally each skill should be a dict of skill and minimum proficiency
        min_degree = data.get("requirements", {}).get("min_degree")
        min_experience = data.get("requirements", {}).get("min_experience")

        sql0 = "select id from user where email = %s"
        cursor.execute(sql0, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404

        user_id = query.get("id") # type: ignore

        if not (user_id and job_title and job_category and employment_type and job_level and country and industry and opening_count and \
                city and work_arrangement and salary_max and salary_min and salary_type and min_degree and min_experience):
            return jsonify({'error': "Not enough information to create a job vacancy."}), 400
        
        if len(skills) > 5:
            return jsonify({'error': "A job vacancy can only have up to 5 required skills."}), 400

        if salary_max < salary_min:
            return jsonify({'error': "Bad salary range"}), 400
        
        if opening_count < 0:
            return jsonify({'error': "Bad opening count"}), 400
        
        connection.start_transaction()

        sql = "insert into job_vacancy(job_responsibilities, required_qualifications, preferred_skills, notes, date_created) values (%s, %s, %s, %s, %s);"
        cursor.execute(sql, [responsibilities, qualifications, preferred_skills, notes, mysql_date])

        post_id = cursor.lastrowid
        
        skills_clause = ""
        skill_params = []
        if len(skills) > 0:
            skills_clause = "insert into skills values (%s, %s, %s)"
            for skill in skills:
                skill_name = skill.get("skill")
                proficiency = skill.get("min_proficiency")
                if not (skill_name and proficiency):
                    return jsonify({'error': "Skill or proficiency is not properly stated"}), 400
                skill_params.append((post_id, skill_name, proficiency))

        sql_employer = "insert into employer_creates_jobpost values (%s, %s);"
        sql_info = "insert into job_information values (%s, %s, %s, %s, %s, %s, %s);"
        sql_location = "insert into job_location values (%s, %s, %s, %s, %s);"
        sql_salary = "insert into salary_benefits values (%s, %s, %s, %s, %s);"
        sql_reqs = "insert into required_education_experience values (%s, %s, %s);"
        sql_skills = f"{skills_clause}"
        
        cursor.execute(sql_employer, [user_id, post_id]) # type: ignore
        cursor.execute(sql_info, [post_id, employment_type, job_title, job_category, industry, job_level, opening_count])
        cursor.execute(sql_location, [post_id, country, district, city, work_arrangement])
        cursor.execute(sql_salary, [post_id, salary_min, salary_max, salary_type, benefits])
        cursor.execute(sql_reqs, [post_id, min_degree, min_experience])
        cursor.executemany(sql_skills, skill_params)
        
        connection.commit()

        return jsonify({'msg': f"Job post {post_id} created successfully", "job_id": post_id}), 200
    except mysql.connector.Error as db_err:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/edit_job/<int:job_id>", methods=['PUT'])
def edit_job_vacancy(job_id):
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") != roles["employer"]:
        return jsonify({'msg': "Only employers can view this page"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Editing a job vacancy")

        data = request.get_json() or {}

        email = session.get("email")

        sql_mail = "select id from user where email = %s"
        cursor.execute(sql_mail, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404

        user_id = query.get("id") # type: ignore

        cursor.execute("select * from job_vacancy where job_id = %s", [job_id])
        if cursor.fetchone() is None:
            return jsonify({'error': "No post with such ID found??"}), 404

        sql_check = "select * from employer_creates_jobpost where employer_id = %s and job_id = %s"
        cursor.execute(sql_check, [user_id, job_id]) # type: ignore
        if cursor.fetchone() is None:
            return jsonify({'error': "This user did not create this post."}), 400
        
        job_title = data.get("basic_info", {}).get("job_title")
        job_category = data.get("basic_info", {}).get("job_category")
        employment_type = data.get("basic_info", {}).get("employment_type")
        industry = data.get("basic_info", {}).get("industry")
        job_level = data.get("basic_info", {}).get("job_level")
        opening_count = data.get("basic_info", {}).get("opening_count")

        country = data.get("location", {}).get("country")
        city = data.get("location", {}).get("city")
        district = data.get("location", {}).get("district")
        work_arrangement = data.get("location", {}).get("work_arrangement")

        salary_min = data.get("wages", {}).get("salary", {}).get("min")
        salary_max = data.get("wages", {}).get("salary", {}).get("max")
        salary_type = data.get("wages", {}).get("type")
        benefits = data.get("wages", {}).get("benefits")

        responsibilities = data.get("description", {}).get("responsibilities")
        qualifications = data.get("description", {}).get("qualifications")
        preferred_skills = data.get("description", {}).get("preferred_skills")
        notes = data.get("description", {}).get("notes")

        skills = data.get("requirements", {}).get("skills")  # Ideally each skill should be a dict of skill and minimum proficiency
        min_degree = data.get("requirements", {}).get("min_degree")
        min_experience = data.get("requirements", {}).get("min_experience")

        if len(skills) > 5:
            return jsonify({'error': "A job vacancy can only have up to 5 required skills."}), 400

        if (salary_min is not None and salary_max is not None) and salary_max < salary_min:
            return jsonify({'error': "Bad salary range"}), 400
        
        if opening_count is not None and opening_count < 0:
            return jsonify({'error': "Bad opening count"}), 400
        
        connection.start_transaction()

        if job_title:
            cursor.execute("update job_information set job_title = %s where job_id = %s", [job_title, job_id])
        if job_category:
            cursor.execute("update job_information set job_category = %s where job_id = %s", [job_category, job_id])
        if employment_type:
            cursor.execute("update job_information set employment_type = %s where job_id = %s", [employment_type, job_id])
        if industry:
            cursor.execute("update job_information set industry = %s where job_id = %s", [industry, job_id])
        if job_level:
            cursor.execute("update job_information set job_level = %s where job_id = %s", [job_level, job_id])
        if opening_count:
            cursor.execute("update job_information set opening_count = %s where job_id = %s", [opening_count, job_id])
        
        if country:
            cursor.execute("update job_location set country = %s where job_id = %s", [country, job_id])
        if city:
            cursor.execute("update job_location set cityprovince = %s where job_id = %s", [city, job_id])
        if district:
            cursor.execute("update job_location set district = %s where job_id = %s", [district, job_id])
        if work_arrangement:
            cursor.execute("update job_location set work_arrangement = %s where job_id = %s", [work_arrangement, job_id])
        
        if salary_min:
            cursor.execute("update salary_benefits set min = %s where job_id = %s", [salary_min, job_id])
        if salary_max:
            cursor.execute("update salary_benefits set max = %s where job_id = %s", [salary_max, job_id])
        if salary_type:
            cursor.execute("update salary_benefits set type = %s where job_id = %s", [salary_type, job_id])
        if benefits:
            cursor.execute("update salary_benefits set benefits = %s where job_id = %s", [benefits, job_id])

        if responsibilities:
            cursor.execute("update job_vacancy set job_responsibilities = %s where job_id = %s", [responsibilities, job_id])
        if qualifications:
            cursor.execute("update job_vacancy set required_qualifications = %s where job_id = %s", [qualifications, job_id])
        if preferred_skills:
            cursor.execute("update job_vacancy set preferred_skills = %s where job_id = %s", [preferred_skills, job_id])
        if notes:
            cursor.execute("update job_vacancy set notes = %s where job_id = %s", [notes, job_id])
        
        if min_degree:
            cursor.execute("update required_education_experience set min_degree_level = %s where job_id = %s", [min_degree, job_id])
        if min_experience:
            cursor.execute("update required_education_experience set min_experience_years = %s where job_id = %s", [min_experience, job_id])

        cursor.execute("delete from required_skills where job_id = %s", [job_id])
        if skills is not None:
            skills_clause = ""
            skill_params = []
            if skills is not None and  len(skills) > 0:
                skills_clause = "insert into skills values (%s, %s, %s)"
                for skill in skills:
                    skill_name = skill.get("skill")
                    proficiency = skill.get("min_proficiency")
                    if not (skill_name and proficiency):
                        return jsonify({'error': "Skill or proficiency is not properly stated"}), 400
                    skill_params.append((job_id, skill_name, proficiency))
                cursor.executemany(skills_clause, skill_params)
        
        connection.commit()

        return jsonify({'msg': f"Job post {job_id} updated successfully"}), 200
    except mysql.connector.Error as db_err:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/delete_job/<int:job_id>", methods=['DELETE'])
def delete_job_vacancy(job_id):
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") in [roles["employer"], roles["admin"]]:
        return jsonify({'msg': "Only employers and admins can use this"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Deleting a job vacancy")

        data = request.get_json() or {}

        email = session.get("email")

        sql_mail = "select id from user where email = %s"
        cursor.execute(sql_mail, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404

        cursor.execute("select * from job_vacancy where job_id = %s", [job_id])
        if cursor.fetchone() is None:
            return jsonify({'error': "No post with such ID found??"}), 404

        sql_check = "select * from employer_creates_jobpost where employer_id = %s and job_id = %s"
        cursor.execute(sql_check, [user_id, job_id]) # type: ignore
        if cursor.fetchone() is None:
            return jsonify({'error': "This user did not create this post."}), 400
        
        connection.start_transaction()
        cursor.execute("delete from job_vacancy where job_id = %s", [job_id])
        
        connection.commit()
        return jsonify({'msg': f"Job post {job_id} deleted successfully"}), 200
    except mysql.connector.Error as db_err:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/admin/list_posts", methods=['GET'])
def admin_get_job_posts():
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") != roles["admin"]:
        return jsonify({'msg': "Only admins can view this page"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Getting list of job posts for admins")

        email = session.get("email")

        sql_mail = "select id from user where email = %s"
        cursor.execute(sql_mail, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404
        
        sql = """
select
ej.employer_id,
jv.job_id,
jv.date_created
from employer_creates_jobpost ej
join job_vacancy jv on ej.job_id = jv.job_id
"""
        cursor.execute(sql)

        query = cursor.fetchall() or []
        
        return jsonify(query), 200
    except mysql.connector.Error as db_err:
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()
            
@app.route("/admin/list_tags", methods=['GET'])
def admin_get_tag_list():
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") != roles["admin"]:
        return jsonify({'msg': "Only admins can view this page"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Getting tag list")

        email = session.get("email")

        sql_mail = "select id from user where email = %s"
        cursor.execute(sql_mail, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404
        
        tags = request.args.get("tags")
        if tags is None or tags not in tags_list:
            return jsonify({'error': "Invalid tags list to retrieve"}), 400

        sql = "select * from %s"

        cursor.execute(sql, [tags])

        query = cursor.fetchall() or []

        return jsonify(query), 200

    except mysql.connector.Error as db_err:
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/admin/delete_tag", methods=['DELETE'])
def admin_delete_tag():
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") != roles["admin"]:
        return jsonify({'msg': "Only admins can view this page"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Deleting tag")

        email = session.get("email")

        sql_mail = "select id from user where email = %s"
        cursor.execute(sql_mail, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404
        
        tags = request.args.get("tags")
        if tags is None or tags not in tags_list:
            return jsonify({'error': "Invalid tags list to retrieve"}), 400
        
        target = request.args.get("target")
        if not target:
            return jsonify({'error': "Invalid tag"}), 400
        
        sql = "delete from %s where name = %s"
        
        connection.start_transaction()
        
        cursor.execute(sql, [tags, target])

        connection.commit()

        return jsonify({'mag': "Deleted tag", 'category': tags, "tag": target}), 200
    except mysql.connector.Error as db_err:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/admin/add_tag", methods=['POST'])
def admin_add_tag():
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") != roles["admin"]:
        return jsonify({'msg': "Only admins can view this page"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Adding new tag")

        email = session.get("email")

        sql_mail = "select id from user where email = %s"
        cursor.execute(sql_mail, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404
        
        tags = request.args.get("tags")
        if tags is None or tags not in tags_list:
            return jsonify({'error': "Invalid tags list to retrieve"}), 400
        
        target = request.args.get("target")
        if not target:
            return jsonify({'error': "Invalid tag"}), 400
        
        sql = "insert into %s values (%s)"
        
        connection.start_transaction()
        
        cursor.execute(sql, [tags, target])

        connection.commit()

        return jsonify({'mag': "Added new tag", 'category': tags, "tag": target}), 200
    except mysql.connector.Error as db_err:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

@app.route("/admin/edit_tag", methods=['PUT'])
def admin_edit_tag():
    if not session.get("email"):
        return jsonify({'msg': "No user logged in"}), 400
    if session.get("role") != roles["admin"]:
        return jsonify({'msg': "Only admins can view this page"}), 403
    
    connection = None
    cursor = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Replacing tag")

        email = session.get("email")

        sql_mail = "select id from user where email = %s"
        cursor.execute(sql_mail, [email])

        query = cursor.fetchone()
        if not query:
            return jsonify({'error': "User not found???"}), 404
        
        tags = request.args.get("tags")
        if tags is None or tags not in tags_list:
            return jsonify({'error': "Invalid tags list to retrieve"}), 400
        
        target = request.args.get("target")
        if not target:
            return jsonify({'error': "Invalid tag"}), 400
        
        cursor.execute("select * from tags where name = %s")
        
        if cursor.fetchone() is None:
            return jsonify({'error': "Target tag to replace not found"}), 404

        replacement = request.args.get("replacement")
        if not target:
            return jsonify({'error': "Invalid replacement tag"}), 400
        
        sql = "update table %s set name = %s where name = %s"
        
        connection.start_transaction()
        
        cursor.execute(sql, [tags, target, replacement])

        connection.commit()

        return jsonify({'mag': "Replaced tag", 'category': tags, "old": target, "new": replacement}), 200
    except mysql.connector.Error as db_err:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Database error: {str(db_err)}'}), 500
    except Exception as e:
        if connection:
            connection.rollback()
        return jsonify({'error': f'Error: {str(e)}'}), 500
    finally:
        if cursor:
            cursor.close()
        if connection:
            connection.close()

if __name__ == '__main__':
    app.run(debug=True, port=5001)