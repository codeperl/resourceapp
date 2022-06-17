import axiosCaller from "../repositories/AxiosRepository";
import { GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS } from '../repositories/HttpCommandsRepository';

export default {
    resourceTypeStore({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(POST, '/admin/resource-types', params)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    resourceTypeShow({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(GET, `/admin/resource-types/${params.id}`)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    resourceTypeUpdate({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(PATCH, `/admin/resource-types/${params.id}`, params)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    resourceTypeDestroy({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(DELETE, `/admin/resource-types/${params.id}`)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    searchResourceTypes({commit}) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(GET, '/admin/resource-types/search')
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
}
