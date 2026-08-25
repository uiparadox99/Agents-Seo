<template>
    <div>
        <div v-if="!$isMobile()">
            <VGHeader></VGHeader>
            <main class="container pt-5 pb-5">
                <div class="row">
                    <div class="col-md-3">
                        <VLSidebar></VLSidebar>
                    </div>
                    <div class="col-md-9">
                         <ContentLoader v-if="loading">
                <rect x="0" y="0" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="20" rx="3" ry="3" width="220" height="10" />
                <rect x="20" y="40" rx="3" ry="3" width="170" height="10" />
                <rect x="0" y="60" rx="3" ry="3" width="250" height="10" />
                <rect x="20" y="80" rx="3" ry="3" width="200" height="10" />
                <rect x="20" y="100" rx="3" ry="3" width="80" height="10" />
              </ContentLoader>
                        <div class="shadow p-4" v-else>
                            <div class="row">
                                <div class="col-md-9">
                                    <h4 class="text-green jr-h-res">
                                       {{mosquedetail.name}} - Detail
                                    </h4>
                                </div>

                                <div class="col-md-3">
                                    <div class="text-right">
                                        <router-link
                                        to="/user/updatemosque"
                                        class="btn p-2 pl-4 pr-4 b-radius  bgc-green text-white">Edit Detail</router-link>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="mt-3 moquedetail-table-pre">
                                <table
                                class="  bordered table  mosque-detail-table  mb-0"
                                >
                                <tbody>
                                    <tr>
                                        <td
                                        class="w-25"
                                        style="border-top:0;"
                                        >
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Mosque Name</strong
                                        >
                                    </td>
                                    <td style="border-top:0;">
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.name}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Contact Person</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.contact_person}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Phone</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.phone}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Mobile</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.mobile}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Email</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.email}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Website</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.website}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Address</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">{{mosquedetail.address}}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Post Code</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">{{mosquedetail.postcode}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >City</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15" v-if="mosquedetail.city != null">{{mosquedetail.city.name}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:18px;"
                                        >Faith</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15" v-if="mosquedetail.theme != null">{{mosquedetail.theme.name}}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                    style="border-bottom: 1px solid #dee2e6;"
                                    >
                                    <strong
                                    style="font-weight:bolder;font-size:18px;"
                                    >Management</strong
                                    >
                                </td>
                                <td
                                style="border-bottom: 1px solid #dee2e6;"
                                >
                                <p class="mb-0 font-size-15" v-if="mosquedetail.council != null">{{mosquedetail.council.name}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="p-2">
                    <h3 class="text-green">Social Media</h3>

                    <div class="mb-1 link-align">
                        <strong>Website : </strong
                            ><a
                            href="javascript:;"
                            class=""
                            style="color: #403939"
                            >
                            {{mosquedetail.website}}
                        </a>
                    </div>

                    <div class="link-align">
                        <strong>FaceBook Link : </strong
                            ><a
                            href="javascript:;"
                            class="text-grey"
                            style="color: #403939"
                            >
                             {{mosquedetail.fblink}}
                        </a>
                    </div>
                    <div class="link-align">
                        <strong>YouTube Link : </strong
                            ><a
                            href="javascript:;"
                            class="text-grey"
                            style="color: #403939"
                            >
                             {{mosquedetail.youtube_link}}
                        </a>
                    </div>
                    <p class="mb-0" style="color: #403939">
                        {{mosquedetail.other_info}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<VFooter></VFooter>
</div>
<div v-if="$isMobile()">
    <VGHeader></VGHeader>
    <main class="container pt-2 pb-2">
     <VLSidebar></VLSidebar>

     <div class="row mb-3">
        <div class="col-md-9">
            <h5 class="text-green jr-h-res mb-1">
                <button
                data-toggle="modal"
                data-target="#sidebar"
                class="btn btn-sm btn float-left user-bar-btn ">
                <i class="fa fa-bars"></i>
            </button>
            {{mosquedetail.name}} - Detail
        </h5>
    </div>

    <div class="col-md-3">
        <div class="text-center">
            <router-link
            to="/user/updatemosque"
            class="btn  pl-4 pr-4 btn-sm   bgc-green text-white">
        Edit Detail</router-link>
    </div>
</div>
</div>
<div class="moquedetail-table-pre">
    <table class="  bordered table  mosque-detail-table">
        <tbody>
              <tr>
                                        <td
                                        class="w-25"
                                        style="border-top:0;"
                                        >
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Mosque Name</strong
                                        >
                                    </td>
                                    <td style="border-top:0;">
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.name}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Contact Person</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.contact_person}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Phone</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.phone}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Mobile</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.mobile}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Email</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.email}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Website</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">
                                            {{mosquedetail.website}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Address</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">{{mosquedetail.address}}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Post Code</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15">{{mosquedetail.postcode}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >City</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15" v-if="mosquedetail.city != null">{{mosquedetail.city.name}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong
                                        style="font-weight:bolder;font-size:14px;"
                                        >Faith</strong
                                        >
                                    </td>
                                    <td>
                                        <p class="mb-0 font-size-15" v-if="mosquedetail.theme != null">{{mosquedetail.theme.name}}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                    style="border-bottom: 1px solid #dee2e6;"
                                    >
                                    <strong
                                    style="font-weight:bolder;font-size:14px;"
                                    >Management</strong
                                    >
                                </td>
                                <td
                                style="border-bottom: 1px solid #dee2e6;"
                                >
                                <p class="mb-0 font-size-15" v-if="mosquedetail.council != null">{{mosquedetail.council.name}}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="p-2">
                        <h5 class="text-green mb-1 text-center">
                            Social Media
                        </h5>

                        <a href="javascript:;" class="text-dark font-size-12"
                        ><strong>FaceBook :</strong> {{mosquedetail.fblink}}
                    </a>
                    <br />
                    <a href="javascript:;" class="text-dark font-size-12"
                    ><strong>YouTube :</strong> {{mosquedetail.youtube_link}}
                    </a
                    ><br />
                    <a href="javascript:;" class="text-dark font-size-12"
                    ><strong>Website :</strong> {{mosquedetail.website}}
                </a>

                <p class="font-size-12 mb-0">
                    {{mosquedetail.other_info}}
                </p>
            </div>
        </div>

    </main>

    <VFooter></VFooter>
</div>
</div>
</template>
<script>
export default {
    data (){
        return {
            loading:true,
            mosquedetail: {},
        }
        
    },
    beforeMount(){
        this.getData();

    },
    methods: {
        getData(){
               
                var dataUrl = 'v1/mosque-detail/'+this.$store.getters.getMosque.slug;
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {
                    var data = result.data.data.detail;
                    this.mosquedetail = data;
                    this.loading = false;
                }, error => {

                });           
            },

    }
}
</script>
