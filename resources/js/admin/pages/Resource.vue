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
                            <h3 class="card-title">Resources</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="resource_type_id">Resource Type</label>
                                        <v-select v-model="resource_type"
                                                  :options="resource_types"
                                                  name="resource_type_id" id="resource_type_id"
                                                  label="text"
                                                  class="form-control form-control-xl" :clearable="false" :default="'Select Resource Type'">
                                            <template #search="{attributes, events}">
                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <component :is="currentResourceForm" v-bind:resource_type="resource_type"></component>
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
                            <h3 class="card-title">List of Resources</h3>
                        </div>
                        <div class="card-body">
                            <data-table ref="tableResources"  class="table-default" :columns="table.columns"
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
    import vSelect from 'vue-select';
    import CommonRepository from '../repositories/CommonRepository';
    import ActionButtonGroup from '../components/laravel_vue_datatable/actions/ActionButtonGroup';
    import { EDIT, DELETE } from '../repositories/ActionButtonsRepository';
    import { API_BASE_PATH, PDF, HTML, LINK } from "../repositories/ConstRepository";
    import PdfResource from './PdfResource';
    import HtmlResource from './HtmlResource';
    import LinkResource from './LinkResource';
    import "vue-select/dist/vue-select.css";

    export default {
        name: 'Resource',
        components: {
            'vSelect': vSelect,
            'PdfResource': PdfResource,
            'HtmlResource': HtmlResource,
            'LinkResource': LinkResource,
        },

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
                            label: 'Resource Type',
                            name: 'resource_type.name',
                            searchable: true,
                            orderable: false,
                        },
                        {
                            label: 'Title',
                            name: 'title',
                            orderable: true,
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
                    url: `/${API_BASE_PATH}/admin/resources`,
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
                resource_types:[{'text':'Select Resource Type', 'value':''}],
                resource_type:{'text':'Select Resource Type', 'value':''},
                resource: {
                    resource_type_id: null,
                    title: '',
                    url: '',
                    description: '',
                    code_snippet: '',
                    open_in_new_tab: false,
                    id: null
                },
                currentResourceForm: '',
                /** Helpers **/
                serverResp: {},
            }
        },
        mounted() {
            this.initAll();
        },
        methods: {
            reloadDatatable() {
                this.$refs.tableResources.getData();
            },

            actionHandler(data, action) {
                if (action === EDIT) {
                    this.editHandler(data);
                } else if (action === DELETE) {
                    this.destroyWithConfirmation(data);
                }
            },

            editHandler(params) {
                this.$store.dispatch('resourceShow', params).then( (resp)=> {
                    console.log('resourceShow request success!');
                    this.serverResp = resp.data;
                    this.resource = resp.data.data;
                    this.resource_type = resp.data.data.resource_type;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                });
            },

            destroyWithConfirmation(params) {
                CommonRepository.destroyWithConfirmation(this.deleteHandler, params);
            },

            deleteHandler(params) {
                return this.$store.dispatch('resourceDestroy', params).then( (resp)=> {
                    console.log('resourceDestroy request success!');
                    this.serverResp = resp.data;
                    this.reloadDatatable();
                    this.initResource();
                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            initAll() {
                this.initResource();
                this.searchResourceTypes();
            },

            initResource() {
                this.$nextTick(() => {
                    this.resource = {
                        resource_type_id: null,
                        title: '',
                        url: '',
                        description: '',
                        code_snippet: '',
                        open_in_new_tab: false,
                        id: null
                    };
                    this.resource_type = {'text':'Select Resource Type', 'value':''};
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            searchResourceTypes() {
                this.$store.dispatch('searchResourceTypes').then( (resp)=> {
                    this.resource_types = resp.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },

            decideResourceComponent(val) {
                if(CommonRepository.resourceTypes().includes(val.text)) {
                    if(val.text === PDF) {
                        this.currentResourceForm = 'PdfResource';
                    } else if(val.text === HTML) {
                        this.currentResourceForm = 'HtmlResource';
                    } else if(val.text === LINK) {
                        this.currentResourceForm = 'LinkResource';
                    } else {
                        this.currentResourceForm = '';
                    }
                }
            }
        },

        watch: {
            resource_type : function(val, oldVal) {
                if(val !== null) {
                    this.resource.resource_type_id = val.id;
                    this.decideResourceComponent(val);
                } else {
                    this.resource.resource_type_id = '';
                    this.currentResourceForm = '';
                }
            },
        }
    }
</script>
