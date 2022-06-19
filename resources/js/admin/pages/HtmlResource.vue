<template>
    <div>
        <validation-observer ref="form" v-slot="{ handleSubmit }">
            <form class="form" method="post" @submit.prevent>
                <div class="row">

                    <div class="col-12">
                        <validation-provider name="title" rules="required|min:3|max:191" v-slot="{ dirty, valid, invalid, errors }">
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

                    <div class="col-md-6 col-12">
                        <validation-provider name="description" rules="min:2|max:10000" v-slot="{ dirty, valid, invalid, errors }">
                            <div class="form-group">
                                <label for="company_summary">Snippet Description</label>
                                <textarea class="form-control form-control-xl" v-model="resource.description" name="description" id="description" rows="3"></textarea>
                                <div class="form-control-feedback" :style="fieldErrorPlaceholder">{{ errors[0] }}</div>
                            </div>
                        </validation-provider>
                    </div>

                    <div class="col-md-6 col-12">
                        <validation-provider name="code_snippet" rules="min:2|max:10000" v-slot="{ dirty, valid, invalid, errors }">
                            <div class="form-group">
                                <label for="code_snippet">HTML snippet</label>
                                <textarea class="form-control form-control-xl" v-model="resource.code_snippet" name="code_snippet" id="code_snippet" rows="10"></textarea>
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

    export default {
        name: 'HtmlResource',
        props: {
            passed_resource: {
                type: Object,
                default: () => ({
                    resource_type_id: null,
                    title: '',
                    description: '',
                    code_snippet: '',
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
                /** Helpers **/
                serverResp: {},
                fieldErrorPlaceholder: {color: 'red'},
            }
        },
        mounted() {
            this.initAll();
        },
        methods: {
            initAll() {},

            initResource() {
                this.$nextTick(() => {
                    this.resource = {
                        resource_type_id: null,
                        title: '',
                        description: '',
                        code_snippet: '',
                        id: null
                    };

                    this.$refs.form.reset();
                });
            },

            isEmptyServerResp() {
                return CommonRepository.isEmptyObject(this.serverResp);
            },


            save() {
                this.resource.resource_type_id = this.resourceType.value;
                let params = this.resource;

                if(CommonRepository.validParamId(params)) {
                    this.create(params);
                } else {
                    this.update(params);
                }
            },

            create(params) {
                return this.$store.dispatch('htmlResourceStore', params).then( (resp)=> {
                    console.log('htmlResourceStore request success!');
                    this.serverResp = resp.data;
                    this.initResource();
                    this.resourceType = {'text':'Select Resource Type', 'value':''};
                    this.$emit('resetResp', resp);

                    return resp;
                }).catch(err => {
                    this.serverResp = err.response.data;
                    this.$emit('resetErr', err);
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },

            update(params) {
                return this.$store.dispatch('htmlResourceUpdate', params).then( (resp)=> {
                    console.log('htmlResourceUpdate request success!');
                    this.serverResp = resp.data;
                    this.initResource();
                    this.resourceType = {'text':'Select Resource Type', 'value':''};
                    this.$emit('resetResp', resp);
                    this.$router.go();

                    return resp;
                }).catch(err => {
                    console.log(err);
                    this.serverResp = err.response.data;
                    this.$emit('resetErr', err);
                    this.$refs.form.setErrors(err.response.data.errors);
                    return Promise.reject(err);
                });
            },
        }
    }
</script>
