async function CallAPI(method,url,body) {
    let header = null;
    if(typeof my_token === 'undefined') {
        header = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    } else {
        header = {
            'Content-Type': 'application/json',
            'Authorization': my_token
        }
    }
    
    if(method == 'GET') {
        return axios.get(url,{
            headers: header,
            params : body
        });
    } else if(method == 'POST') {
        var data = body
        var headers = {
            withCredentials: false,
            headers: header
        }
        return axios.post(url,data,headers);
    } else if(method == 'PUT') {
        var data = body
        var headers = {
            withCredentials: false,
            headers: header
        }
        return axios.put(url,data,headers);
    } else if(method == 'DELETE') {
        return axios.delete(url,{
            headers: header,
            params : body
        });
    }
}