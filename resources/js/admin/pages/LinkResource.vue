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
                            <input type="file" id="url" name="url" hidden accept="application/pdf" /> <!--implement customization.-->
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
        name: 'LinkResource',
        props: {
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
                resource: {
                    resource_type_id: null,
                    title: '',
                    url: '',
                    open_in_new_tab: false,
                    id: null
                },
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
            initAll() {
                this.initResource();
            },

            initResource() {
                this.$nextTick(() => {
                    this.resource = {
                        resource_type_id: null,
                        title: '',
                        url: '',
                        open_in_new_tab: false,
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
                return this.$store.dispatch('linkResourceStore', params).then( (resp)=> {
                    console.log('linkResourceStore request success!');
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
                return this.$store.dispatch('linkResourceUpdate', params).then( (resp)=> {
                    console.log('linkResourceUpdate request success!');
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
        }
    }
</script>
