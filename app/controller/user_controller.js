const API_BASE = 'http://127.0.0.1:5001';


/**
 * Fetch job vacancy cards, taking filters and sorts into account, and return an array
 * @param {Dictionary} args Structure (all of the keys are optional): {keyword, job_category, country, cityprovince,
 *  skills[skill], employment_type, job_level, salary{min, max}, work_arrangement, sort{by, order}}
 * @returns Data structure: cards[{id, job_title, industry, job_level, work_arrangement, salary_min, salary_max, date_created}]
 */
export async function get_vacancy_cards(args) {
    try {
        const response = await fetch(`${API_BASE}/home`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(args)
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Logs in
 * 
 * @param {*} args Structure: {email, password, role}
 * @returns Structure: {email, role}
 */
export async function login(args) {
    try {
        const response = await fetch(`${API_BASE}/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(args)
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Logs out
 * 
 * @returns Nothing!
 */
export async function logout() {
    try {
        const response = await fetch(`${API_BASE}/logout`, {
            method: "POST"
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}


/**
 * 
 * @param {*} args Structure: {email, password, role, name}
 * @returns Structure: {email, role, name}
 */
export async function register(args) {
     try {
        const response = await fetch(`${API_BASE}/register`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(args)
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Returns every detail of a job vacancy
 * 
 * @param {int} job_id Job vacancy ID
 * @returns Structure: {details{job_id, employment_type, job_title, job_category, industry, job_level, opening_count, country, district, cityprovince, work_arrangement, salary_min, salary_max, salary_type, benefits, job_responsibilities, required_qualifications, preferred_skills, notes, date_created, min_degree_level, min_experience_years}, skills[skill, min_proficiency]}
 */
export async function get_job_vacancy(job_id) {
    try {

        const response = await fetch(`${API_BASE}/jobs/${job_id}`, {
            method: "GET"
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Creates a job vacancy
 * 
 * @param {*} args Structure: {basic_info{employment_type, job_title, job_category, industry, job_level, opening_count}, location{country, district, cityprovince, work_arrangement}, wages{salary{min, max}, salary_type, benefits}, description{responsibilities, qualifications, preferred skills, notes}, skills[skill, min_proficiency], requirements{min_degree, min_experience}}
 * @returns Structure: {job_id}
 */
export async function create_job_vacancy(args) {
    try {

        const response = await fetch(`${API_BASE}/new_job_vacancy`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(args)
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Edits a job vacancy
 * 
 * @param {*} args Structure (optional): {basic_info{employment_type, job_title, job_category, industry, job_level, opening_count}, location{country, district, cityprovince, work_arrangement}, wages{salary{min, max}, salary_type, benefits}, description{responsibilities, qualifications, preferred skills, notes}, skills[skill, min_proficiency], requirements{min_degree, min_experience}}
 * @param {int} job_id
 * @returns Nothing!
 */
export async function edit_job_vacancy(args, job_id) {
    try {

        const response = await fetch(`${API_BASE}/edit_job/${job_id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(args)
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Deletes a job vacancy
 * 
 * @param {int} job_id 
 * @returns Nothing!
 */
export async function delete_job_vacancy(job_id) {
    try {

        const response = await fetch(`${API_BASE}/delete_job/${job_id}`, {
            method: "DELETE"
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Returns job vacancy list (admin)
 * 
 * @returns structure: query[{employer_id, job_id, date_created}]
 */
export async function admin_get_vacancy_list() {
    try {
        const response = await fetch(`${API_BASE}/admin/list_posts`, {
            method: "GET",
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Returns a list of tags in that category
 * 
 * @param {*} which String name of the tag list. Check sql file to know what to query for
 * @returns Structure: query[{name}]
 */
export async function get_tag_list(which) {
    try {
        const response = await fetch(`${API_BASE}/admin/list_tags?tags=${which}`, {
            method: "GET"
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Add a new tag to the specified tag list
 * 
 * @param {*} which_list Which list to add tag to
 * @param {*} tag Name of the new tag
 * @returns 
 */
export async function add_tag(which_list, tag) {
    try {
        const response = await fetch(`${API_BASE}/admin/add_tag?tags=${which_list}&target=${tag}`, {
            method: "POST"
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Deletes a tag from the specified tag list
 * 
 * @param {*} which_list Which list to delete tag
 * @param {*} tag Name of the new tag
 * @returns 
 */
export async function delete_tag(which_list, tag) {
    try {
        const response = await fetch(`${API_BASE}/admin/delete_tag?tags=${which_list}&target=${tag}`, {
            method: "DELETE"
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}

/** Replaces a tag from a list with a new one
 * 
 * @param {*} which_list Which list to edit
 * @param {*} tag Name of the old tag to replace
 * @param {*} new_tag Name of the new tag
 * @returns 
 */
export async function edit_tag(which_list, tag, new_tag) {
    try {
        const response = await fetch(`${API_BASE}/admin/delete_tag?tags=${which_list}&target=${tag}&replacement=${new_tag}`, {
            method: "PUT"
        });

        const data = await response.json();

        return data;
    }
    catch(error) {
        console.error("Error: ", error);
        return [];
    }
}