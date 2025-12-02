export async function fetchAPI(url, options = {}) {
    const token = localStorage.getItem('token');

    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        }
    };

    const response = await fetch(url, {...defaultOptions, ...options});

    if (!response.ok) throw new Error("API error");
    return response.json();
}
