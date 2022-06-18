import axiosCaller from "../repositories/AxiosRepository";
import { GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS } from '../repositories/HttpCommandsRepository';
import { MULTIPART_FORM_DATA_HEADER } from "../repositories/HttpHeadersRepository";

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

    resourceShow({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(GET, `/admin/resources/${params.id}`)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    resourceDestroy({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(DELETE, `/admin/resources/${params.id}`)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    pdfResourceStore({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(POST, '/admin/pdf-resources', params, { headers:MULTIPART_FORM_DATA_HEADER})
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    pdfResourceUpdate({commit}, params) {
        return new Promise((resolve, reject) => {
            // Get id from FormData object named params.
            axiosCaller.callApi(POST, `/admin/pdf-resources/${params.get('id')}`, params, { headers:MULTIPART_FORM_DATA_HEADER})
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    htmlResourceStore({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(POST, '/admin/html-resources', params)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    htmlResourceUpdate({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(PATCH, `/admin/html-resources/${params.id}`, params)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    linkResourceStore({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(POST, '/admin/link-resources', params)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },

    linkResourceUpdate({commit}, params) {
        return new Promise((resolve, reject) => {
            axiosCaller.callApi(PATCH, `/admin/link-resources/${params.id}`, params)
                .then(resp => {
                    resolve(resp);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
}
