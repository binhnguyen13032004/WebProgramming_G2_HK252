const API_BASE = 'http://127.0.0.1:5001';


/**
 * Fetch job vacancy cards, taking filters and sorts into account, and return an array
 * @param {Dictionary} args Filters and sorts for vacancy cards. May have keys: keyword, job_category, country, cityprovince,
 *  skills[], employment_type, job_level, salary{min, max}, work_arrangement, sort{by, order}
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