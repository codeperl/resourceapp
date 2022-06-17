import axios from "axios";
import { GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS } from './HttpCommandsRepository';
import { API_BASE_PATH } from "./ConstRepository";

export default {
    apiBasePath: API_BASE_PATH,
    basePath: '',
    call: async function(basePath, requestType=GET, url='', params={}, headers={}, showLoader=false) {
        url = basePath+url;

        const methodName = requestType.toUpperCase();
        if(methodName === GET ) {
            return await  axios.get(url, params, headers)
                .then(response => {return response;})
                .catch(error => { return error;})
        } else if(methodName === POST ) {
            return await  axios.post(url, params, headers)
                .then(response => {return response;})
        } else if(methodName === PATCH ) {
            return await  axios.patch(url, params, headers)
                .then(response => {return response;})
        } else if(methodName === DELETE ) {
            return await  axios.delete(url, headers)
                .then(response => {return response;})
        } else{
            console.log('Invalid request method');
            return false;
        }
    },
    callWeb: async function(requestType=GET, url='', params={}, headers={}, showLoader=false) {
        return this.call(this.basePath, requestType, url, params, headers, showLoader);
    },
    callApi: async function(requestType=GET, url='', params={}, headers={}, showLoader=false) {
        return this.call(this.apiBasePath, requestType, url, params, headers, showLoader);
    },
}
