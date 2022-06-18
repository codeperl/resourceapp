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
                            <validation-observer ref="form" v-slot="{ handleSubmit }">
                                <form class="form" method="post" @submit.prevent>
                                    <div class="row">

                                        <div class="col-12">
                                            <validation-provider name="title" rules="required|min:3|max:150" v-slot="{ dirty, valid, invalid, errors }">
                                                <div class="form-group has-icon-left">
                                                    <label for="title">Title</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control form-control-xl" v-model="resource.title" name="title" placeholder="Title" id="title" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-building"></i>
                                                        </div>
                                                    </div>
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div class="col-12">
                                            <validation-provider name="resource_type_id" rules="required" v-slot="{ dirty, valid, invalid, errors }">
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
                                                    <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                                                </div>
                                            </validation-provider>
                                        </div>

                                        <div v-if="isPdfResource()">
                                            <validation-provider name="url" rules="min:3" v-slot="{ dirty, valid, invalid, errors }">
                                                <!--default html file upload button-->
                                                <input type="file" id="url" name="url" hidden @change="getFile" accept="image/*" />
                                            </validation-provider>
                                        </div>
                                        <div v-else-if="isHtmlResource()">
                                            Html resource
                                        </div>
                                        <div v-else-if="isLinkResource()">
                                            Link
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
    import "vue-select/dist/vue-select.css";

    export default {
        name: 'HtmlResource',
        components: {
            'vSelect': vSelect,
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
                            label: 'Person Name',
                            name: 'person_name',
                            orderable: true,
                        },
                        {
                            label: 'Designation',
                            name: 'designation',
                            orderable: true,
                        },
                        {
                            label: 'Order',
                            name: 'order',
                            orderable: true,
                        },
                        {
                            label: 'Primary Resource?',
                            name: 'primary_resource',
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
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
                keepDisable: false,
                disabled: false,
            }
        },
        mounted() {
            this.initAll();
        },
        methods: {
            isPdfResource() {
                return this.resource_type.text === PDF;
            },

            isHtmlResource() {
                return this.resource_type.text === HTML;
            },

            isLinkResource() {
                return this.resource_type.text === LINK;
            },

            getFile(event) {
                let that = this;
                let input = event.target;

                let readerBuffer = new FileReader();
                let readerDataURL = new FileReader();

                if (input.files && input.files[0]) {
                    this.path = input.files[0];
                    readerDataURL.readAsDataURL(input.files[0]);

                    readerDataURL.onload = (e) => {
                        that.content = readerDataURL.result;
                    };

                    readerBuffer.onloadend = (e) => {
                        const bytes = new Uint8Array(e.target.result);
                        that.extension = filetypeextension(bytes).pop();
                        that.mimeType = filetypemime(bytes).pop();
                    };

                    readerBuffer.readAsArrayBuffer(input.files[0]);
                }
            },

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
                    this.$set(this.resource, 'photo', fileUrl);
                }
            },

            save() {
                let params = this.resource;

                if(params.id===null) {
                    this.$store.dispatch('resourceStore', params).then( (resp)=> {
                        console.log('resourceStore request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initResource();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                } else {
                    this.$store.dispatch('resourceUpdate', params).then( (resp)=> {
                        console.log('resourceUpdate request success!');
                        this.serverResp = resp.data;
                        this.reloadDatatable();
                        this.initResource();
                    }).catch(err => {
                        this.serverResp = err.response.data;
                        this.$refs.form.setErrors(err.response.data.errors);
                    });
                }
            },

            searchResourceTypes() {
                this.$store.dispatch('searchResourceTypes').then( (resp)=> {
                    this.resource_types = resp.data.data;
                }).catch(err => {
                    console.log(err);
                });
            },
        },

        watch: {
            resource_type : function(val, oldVal) {
                if(val !== null) {
                    this.resource.resource_type_id = val.id;
                } else {
                    this.resource.resource_type_id = '';
                }
            },
        }
    }
</script>
