import mysql.connector
import bcrypt
from flask import Flask, request, jsonify
from flask_cors import CORS
import os

app = Flask(__name__)
CORS(app)

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


@app.route('/home', methods=['POST'])
def fetch_all_post_cards():
    cursor = None
    connection = None

    try:
        connection = mysql.connector.connect(**db)
        cursor = connection.cursor(dictionary=True)
        print("Filtering and fetching all posts...")

        data = request.get_json()

        print(data)

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
            filters.append(f"exists (select 1 from `required_skills` as rs where rs.`job_id` = jv.`id` and rs.`skill` in ({placeholder}))")
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
ji.`job_title` as `job_title`,
ji.`industry` as `industry`,
ji.`job_level` as `job_level`,
jl.`work_arrangement` as `work_arrangement`,
sb.`min` as `salary_min`,
sb.`max` as `salary_max`,
jv.`date_created` as `date_created`
from `job_information` as ji
join `job_vacancy` as jv on jv.`id` = ji.`job_id`
join `job_location` as jl on jv.`id` = jl.`job_id`
join `salary_benefits` as sb on jv.`id` = sb.`job_id`
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

if __name__ == '__main__':
    app.run(debug=True, port=5001)