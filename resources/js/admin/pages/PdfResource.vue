<template>
    <div>
        <validation-observer ref="form" v-slot="{ handleSubmit }">
            <form class="form" method="post" @submit.prevent>
                <div class="row">

                    <div class="col-6">
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

                    <div class="col-6">
                        <validation-provider name="url" rules="min:3" v-slot="{ dirty, valid, invalid, errors }">
                            <div class="form-group has-icon-right">
                                <label for="url">Upload PDF</label>
                                <div class="position-relative">
                                    <input type="file" id="url" name="url" @change="getFile" accept="application/pdf" />
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
</template>

<script>
    import CommonRepository from '../repositories/CommonRepository';
    import { objectToFormData } from '../transformers/ObjectToFormData';

    export default {
        name: 'PdfResource',
        props: {
            passed_resource: {
                type: Object,
                default: () => ({
                    resource_type_id: null,
                    title: '',
                    url: '',
                    id: null
                })
            },
            resource_type: {
                type: Object,
                default: () => ({
                    text: '',
                    value: null,
                })
            }
        },
        data() {
            return {
                resource:  JSON.parse(JSON.stringify(this.passed_resource)),
                resourceType: JSON.parse(JSON.stringify(this.resource_type)),
                pdfFile: '',
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
            }
        },

        mounted() {
            this.initAll();
        },

        methods: {
            getFile(event) {
                let input = event.target;

                if (input.files && input.files[0]) {
                    this.pdfFile = input.files[0];
                }
            },

            initAll() {},

            initResource() {
                this.$nextTick(() => {
                    this.resource = {
                        resource_type_id: null,
                        title: '',
                        url: '',
                        id: null
                    };

                    this.pdfFile = '';

                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },

            save() {
                this.resource.resource_type_id = this.resourceType.value;
                let params = objectToFormData(this.resource);
                params.append('url', this.pdfFile);

                if(CommonRepository.validParamId(this.resource)) {
                    this.create(params);
                } else {
                    this.update(params);
                }
            },

            create(params) {
                return this.$store.dispatch('pdfResourceStore', params).then( (resp)=> {
                    console.log('pdfResourceStore request success!');
                    this.serverResp = resp.data;
                    this.initResource();
                    this.resourceType = {'text':'Select Resource Type', 'value':''};

                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            update(params) {
                return this.$store.dispatch('pdfResourceUpdate', params).then( (resp)=> {
                    console.log('pdfResourceUpdate request success!');
                    this.serverResp = resp.data;
                    this.initResource();
                    this.resourceType = {'text':'Select Resource Type', 'value':''};

                    return resp;
                }).catch(err => {
                    console.log(err);
                    this.serverResp = err.response.data;
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },
        },
    }
</script>
