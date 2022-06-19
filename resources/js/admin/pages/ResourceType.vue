<template>
    <div class="page-heading">
        <div class="row">
            <div class="col-12" v-if="!isEmptyServerResp()" key="not_empty_resp">
                <div class="alert " :class="(serverResp.status===true) ? 'alert-success' : 'alert-danger'">
                    <i class="bi bi-check-circle" v-if="(serverResp.status===true)" key="server_resp_true"></i>
                    <i class="bi bi-file-excel" v-else></i>
                    {{ serverResp.message }}
                </div>
            </div>
        </div>

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Resource Types</h3>
                        </div>
                        <div class="card-body">
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">
                                        <div class="col-12">
                                            <validation-provider name="name" rules="required|min:3|max:100" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="name">Exact Name (Pdf Download, Html Snippet, Link)</label>
                                                    <div class="position-relative">
                                                        <input autocomplete="off" type="text" class="form-control form-control-xl" v-model="resourceType.name" name="name" placeholder="Name" id="name" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-md-12 col-12">
                                            <validation-provider name="slug" rules="min:3|max:200" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="slug">Slug</label>
                                                    <div class="position-relative">
                                                        <input autocomplete="off" disabled type="text" class="form-control form-control-xl" v-model="resourceType.slug" name="slug" placeholder="Slug" id="slug">
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-map"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary my-1 btn-lg" @click.prevent="handleSubmit(save)">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </validation-observer>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
        <section class="section">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Resource Types</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableResourceTypes"  class="table-default" :columns="table.columns"
                                        :url="table.url" :classes="table.classes" :debounce-delay="500">
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import CommonRepository from '../repositories/CommonRepository';
    import ActionButtonGroup from '../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../repositories/ActionButtonsRepository';
    import { API_BASE_PATH } from "../repositories/ConstRepository";

    export default {
        name: 'ResourceType',
        data() {
            return {
                table: {
                    columns: [
                        {
                            label: 'ID',
                            name: 'id',
                            orderable: true
                        },
                        {
                            label: 'Name',
                            name: 'name',
                            orderable: true,
                        },
                        {
                            label: 'slug',
                            name: 'slug',
                            orderable: false,
                        },
                        {
                            label: 'Actions',
                            name: JSON.stringify({
                                buttons: [
                                    { name: EDIT, iconClass: "bi bi-pencil-square" },
                                    { name: DELETE, iconClass: "bi bi-trash" },
                                ],
                            }),
                            data: {
                                EDIT: EDIT,
                                DELETE: DELETE
                            },
                            orderable: false,
                            classes: {
                                'btn': true,
                                'btn-md': true,
                                'me-4': true,
                            },
                            event: "click",
                            handler: this.actionHandler,
                            component: ActionButtonGroup,
                        },
                    ],
                    url: `/${API_BASE_PATH}/admin/resource-types`,
                    classes: {
                        "table-container": {
                            "table-responsive": true,
                        },
                        "table": {
                            "table": true,
                            "table-striped": true,
                            "table-hover": true,
                            "align-middle": true,
                            "py-2": true,
                        },
                        "t-head": {
                            "bg-primary": true,
                            "text-white": true,
                        },
                        "t-body": {

                        },
                        "t-head-tr": {

                        },
                        "t-body-tr": {

                        },
                        "td": {
                            "text-center": true,
                        },
                        "th": {
                            "text-center": true,
                        },
                    }
                },
                resourceType: {
                    name: '',
                    slug: '',
                    id: null
                },
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        mounted() {
        },
        methods: {
            reloadDatatable() {
                this.$refs.tableResourceTypes.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('resourceTypeShow', params).then( (resp)=> {
                    console.log('resourceTypeShow request success!');
                    this.serverResp = resp.data;
                    this.resourceType = resp.data.data;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('resourceTypeDestroy', params).then( (resp)=> {
                    console.log('resourceTypeDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initResourceType();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.initResourceType();
            },

            initResourceType() {
                this.$nextTick(() => {
                    this.resourceType = {
                        name: '',
                        slug: '',
                        id: null
                    };
                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            getFileUrl(fileUrl, elem) {
                this.setByField(fileUrl, elem);
            },

            setByField(fileUrl, elem) {
                if(elem==='photo') {
                    this.$set(this.resourceType, 'photo', fileUrl);
                }
            },

            save() {
                let params = this.resourceType;

                if(params.id===null) {
                    this.$store.dispatch('resourceTypeStore', params).then( (resp)=> {
                        console.log('resourceTypeStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initResourceType();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('resourceTypeUpdate', params).then( (resp)=> {
                        console.log('resourceTypeUpdate request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initResourceType();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },
        },
    }
</script>
