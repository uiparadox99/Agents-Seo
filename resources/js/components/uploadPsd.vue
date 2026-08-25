<template>
    <div>
        <VGHeader class="inner-nav"></VGHeader>
        <main class="overflow-hidden position-relative">
            <div style="border:1px solid 
        #ddd;padding: 30px;margin:150px auto;border-radius: 8px;width:80%">
                <form role="form" class="contactForm" enctype="multipart/form-data" style="" @submit.prevent="submit()">
                    <div>
                        <h2 class="text-center">Template</h2>
                        <div class="row">
                              <div class="col-md-4 form-group">
                                  <label>Files</label>
                                                                    <input type="file" class="form-control" name="" ref="file" multiple="" @change="getRemainfiles" required=""> 
                                <!-- <label>Preview Image</label>
                                <input type="file" name="main_img" required="" class="form-control" @change="getMainFile">  -->
                            </div>
                         <div class="col-md-4 form-group">
                            <label>Title</label>
                            <input type="text" name="title" required="" class="form-control" v-model="form.title" placeholder="Title"> 
                        </div>
                            <div class="col-md-4 form-group">
                                <label>Category</label>
                                <select name="category" class="form-control" required="" v-model="form.category">
                                    <option value="">Select</option>
                                    <option v-for="c in categories" :value="c.id">{{c.name}}</option>
                                </select>
                            </div>
                            <div class="col-md-2  form-group">
                                <label>Type</label>
                                <select name="type" class="form-control" required="" v-model="form.type">
                                    <option value="">Select</option>
                                    <option value="posters">Poster</option>
                                    <option value="flayers">Flayer</option>
                                    <option value="business_cards">Business Cards</option>
                                </select>
                            </div>
                             <div class="col-md-1 pl-0 pr-0 form-group">
                                <label>Orientation</label>
                                <select name="orientation" class="form-control" required="" v-model="form.orientation">
                                    <option value="portrait">Portrait</option>
                                    <option value="landscape">Landscape</option>
                                </select>
                            </div>
                          
                        </div>
                           <div class="row">
                                                           
                                                            <!-- <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Files</label>
                                                                    <input type="file" class="form-control" name="" ref="file" multiple="" @change="getRemainfiles" required=""> 
                                                                </div>
                                                                 </div> -->
                                                                     <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Add Bg color</label>
                                                                    <input type="text" name="" :id="'bgColor'" class="form-control" @change="setcolor()">
                                                                </div>
                                                                <!-- <div v-if="typeof file.psd != 'undefined' ">


                                                                    <ul class="nav nav-tabs">
                                                                        <li class="nav-item" v-for="(slot,slotkey) in file.psd"> <a class="nav-link " v-bind:class="{'active': slotkey == 0}" :id="'device'+contentkey+fkey+slotkey" data-toggle="tab" :href="'#devicepanel'+contentkey+fkey+slotkey" role="tab" v-if="slot.name.includes('frame') || typeof slot.text != 'undefined'"><b>{{slot.name}}</b></a> </li>
                                                                    </ul>
                                                                    <div class="tab-content">
                                                                        <div v-for="(slot,slotkey) in file.psd" class="fade tab-pane" v-bind:class="{'show active': slotkey == 0}" :id="'devicepanel'+contentkey+fkey+slotkey" role="tabpanel">
                                                                            <br>
                                                                            <div class="row" v-if="slot.name.includes('frame')">
                                                                                <div class="col-md-6 form-group">
                                                                                    <label>Device Type</label>
                                                                                    <select name="device_type" :data-device="contentkey" :data-file="fkey" :data-layer="slotkey" class="form-control" v-model="slot.deviceType" @change="setinnerData(contentkey,fkey,slotkey)" >
                                                                                        <option value="full_device">Full Device</option>
                                                                                        <option value="3D_left">3D View Left</option>
                                                                                        <option value="3D_right">3D View Right</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-6 form-group" v-if="slot.deviceType == 'full_device'">
                                                                                    <label>Rotation</label>
                                                                                    <input type="text" name="rotation" :data-device="contentkey" :data-file="fkey" :data-layer="slotkey" @change="setinnerData(contentkey,fkey,slotkey)" class="form-control" placeholder="Rotation in degree" v-model="slot.imgRoation">
                                                                                </div>
                                                                                <div class="col-md-6 form-group">
                                                                                    <label>Frame Position</label>
                                                                                    <select name="object_postition" :data-device="contentkey" :data-file="fkey" :data-layer="slotkey" @change="setinnerData(contentkey,fkey,slotkey)" class="form-control" v-model="slot.objectPosition" >
                                                                                        <option value="center">Center</option>
                                                                                        <option value="top">Top</option>
                                                                                        <option value="bottom">Bottom</option>
                                                                                        <option value="left">Left</option>
                                                                                        <option value="right">Right</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row" v-else-if=" typeof slot.text != 'undefined'">
                                                                                <div class="col-md-12">
                                                                                     <h4 class="text-center">{{slot.text.value}}</h4>
                                                                                   
                                                                                    <label>Text align</label>
                                                                                     <select name="TextCenter" class="form-control" v-model="slot.TextCenter" >
                                                                                        <option value="center">Center</option>
                                                                                        <option value="left">Left</option>
                                                                                        <option value="right">Right</option>
                                                                                    </select>
                                                                                  </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                            </div>
                                                        </div>
                     
                        <br>
                        <div class="alert alert-success alert-dismissible " role="alert" v-if="success_message != ''">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&#10006;</span>
                            </button>
                            <span v-html="success_message"></span>
                        </div>
                        <div class="alert alert-danger alert-dismissible " role="alert" v-if="error_message != ''">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&#10006;</span>
                            </button>
                            <span v-html="error_message"></span>
                        </div>
                        <div class="text-center">
                            <input type="submit" class="btn  btn-primary" value="Upload Now">
                        </div>
                    </div>
                </form>
            </div>
        </main>
       
        <VFooter class="inner-footer"></VFooter>
    </div>
</template>
<script>
import PSD from 'psd.js'
import * as fs from 'fs-web';
export default {
    data() {
            return {
                detail: '',
                categories: {},
                dFiles: [],
                error_message: "",
                has_error: false,
                submitted: false,
                final: '',
                current_read_file: '',
                screens: 8,
                tumbnail: '',
                bg: '',
                success_message: '',
                psd: '',
                slots: {},
                  files: {},
                devices: {
                    iphone5: {
                        name: 'iOS Phones - 5.5"',
                        width: '287.48',
                        height: '622.22',
                        files: {},
                        colors: {
                            matt_black: {
                                url: 'https://storage.googleapis.com/flyermaker-b986d.appspot.com/t4frame1-1_slot.png?GoogleAccessId=firebase-adminsdk-fupyn%40flyermaker-b986d.iam.gserviceaccount.com&Expires=3824218800&Signature=RJYZ9aN6dHKrxssWyvoeRBhhfbJeUs5NsvlI3oWZ2idS2OpQPCpuofoH9pUBNGmK%2FMbyczb%2BaYIb%2B7pGQE2b79NyyKVvwlkJAQM4FgTjWU9dnYwk2jz1ONOdpx9d8Oa46UzhVhbRWbsWpTrh9zyun0MGVLTPwOToSGcxzEEnPDQcDqn9y8wfwPNh76ZMahmFvaGdFMBZ6%2BY2dCU4uyt26edhQyjv837BSv6lSH%2FHcEMquqZOu3NQOjMwgDBrNTX4hfnFLQahcK84sHzYpmZw4ogMFw96Ui%2BlE88aqziBR8WHpQcLDQGmC9nGrIZ3i8Er8JiHweQkGWNj28mYNefJ1g%3D%3D',
                                name: 'Matt Black'
                            },
                        }
                    },
                    iphone6: {
                        name: 'iOS Phones - 6.5"',
                        width: '700',
                        height: '1000',
                        files: {},
                        colors: {
                            matt_black: {
                                url: 'https://storage.googleapis.com/flyermaker-b986d.appspot.com/t4frame1-1_slot.png?GoogleAccessId=firebase-adminsdk-fupyn%40flyermaker-b986d.iam.gserviceaccount.com&Expires=3824218800&Signature=RJYZ9aN6dHKrxssWyvoeRBhhfbJeUs5NsvlI3oWZ2idS2OpQPCpuofoH9pUBNGmK%2FMbyczb%2BaYIb%2B7pGQE2b79NyyKVvwlkJAQM4FgTjWU9dnYwk2jz1ONOdpx9d8Oa46UzhVhbRWbsWpTrh9zyun0MGVLTPwOToSGcxzEEnPDQcDqn9y8wfwPNh76ZMahmFvaGdFMBZ6%2BY2dCU4uyt26edhQyjv837BSv6lSH%2FHcEMquqZOu3NQOjMwgDBrNTX4hfnFLQahcK84sHzYpmZw4ogMFw96Ui%2BlE88aqziBR8WHpQcLDQGmC9nGrIZ3i8Er8JiHweQkGWNj28mYNefJ1g%3D%3D',
                                name: 'Matt Black'
                            },
                        }
                    },
                    ipad2: {
                        name: 'iOS iPad Pro (2nd) - 12.9"',
                        width: '350',
                        height: '466.895',
                        files: {},
                        colors: {
                            matt_black: {
                                url: 'https://storage.googleapis.com/flyermaker-b986d.appspot.com/t4frame1-1_slot.png?GoogleAccessId=firebase-adminsdk-fupyn%40flyermaker-b986d.iam.gserviceaccount.com&Expires=3824218800&Signature=RJYZ9aN6dHKrxssWyvoeRBhhfbJeUs5NsvlI3oWZ2idS2OpQPCpuofoH9pUBNGmK%2FMbyczb%2BaYIb%2B7pGQE2b79NyyKVvwlkJAQM4FgTjWU9dnYwk2jz1ONOdpx9d8Oa46UzhVhbRWbsWpTrh9zyun0MGVLTPwOToSGcxzEEnPDQcDqn9y8wfwPNh76ZMahmFvaGdFMBZ6%2BY2dCU4uyt26edhQyjv837BSv6lSH%2FHcEMquqZOu3NQOjMwgDBrNTX4hfnFLQahcK84sHzYpmZw4ogMFw96Ui%2BlE88aqziBR8WHpQcLDQGmC9nGrIZ3i8Er8JiHweQkGWNj28mYNefJ1g%3D%3D',
                                name: 'Matt Black'
                            },
                        }
                    }
                },
                form: {
                    id: '',
                    category: '',
                    type: 'posters',
                    title: '',
                    orientation: 'portrait',
                    paid: 1,
                    main_img: '',
                    active: 1,
                }
            }
        },
        components: {
        },
        beforeMount(){
            this.getCategories();
        },
        mounted() {
            this.runscript();
        },
        methods: {
            runscript() {
                $(document).ready(function() {
                    var clickCount = 0;
                });
            },
            getCategories(){
                var dataUrl = '/categories/';
                axios({ method: "GET", "url":dataUrl, "headers": { "content-type": "application/json" } }).then(result => {

                    this.categories = result.data.categories
                    this.loading = false;

                }, error => {

                });           
            },
            getMainFile(e){
                 this.readMainFile(e.target.files[0]);
            },
            readMainFile(file) {
                var $this = this;
                var reader = new FileReader();
                reader.onload = function() {
                    var code = reader.result;
                    $this.form.main_img = code;
                };
                reader.readAsDataURL(file);
            },
            getMultifiles(e) {
                var dKey = e.target.dataset.device;
                var files = e.target.files;
                var $this = this;
                var count = 1;
                var endResult;
                if(files.length) {
                    for(var i = 0; i <= files.length; i++) {
                        var file = files[i];
                        if(typeof file != 'undefined' && file != '') {
                            $this.dFiles[i] = {};
                            $this.dFiles[i]['final'] = file;
                            $this.dFiles[i]['preview'] = '';
                            $this.readFile(file, i);
                            count++;
                        }
                    }
                }
                this.devices[dKey].files = this.dFiles;
                setTimeout(function() {
                    $this.$forceUpdate();
                    $this.dFiles = []
                }, 2000);
            },
            getRemainfiles(e) {
                var dKey = 'iphone6';
                var fKey = 0;
                var files = e.target.files;
                var $this = this;
                var count = 1;
                var endResult;
                if(files.length) {
                    for(var i = 0; i <= files.length; i++) {
                        var file = files[i];
                        if(typeof file != 'undefined') {
                            if(file.name.includes('-final')) {
                                $this.readRemainFile(file,'final');
                              /*  $this.devices[dKey].files[fKey]['final'] = file;*/
                            }
                            if(file.name.includes('-thum')) {
                                $this.readRemainFile(file,'thum');
                                /*$this.devices[dKey].files[fKey]['thum'] = file;*/
                            }
                            if(file.name.includes('-bg') || file.name.includes('-BG')) {
                                $this.readRemainFile(file,'bg');
                               /* $this.devices[dKey].files[fKey]['bg'] = file;*/
                            }
                            if(file.name.includes('-inbg') || file.name.includes('-INBG')) {
                                $this.readRemainFile(file,'inbg');
                               /* $this.devices[dKey].files[fKey]['bg'] = file;*/
                            }
                            if(file.name.includes('.psd')) {
                                $this.files['psd'] = file;
                                $this.extractPSD(dKey, fKey);
                            }
                            if(file.name.includes('slot')) {
                                if(typeof $this.files.slots == 'undefined') {
                                    $this.files.slots = {};
                                }
                                $this.files.slots[count] = {};
                                $this.readRemainFile(file,'slot',count);
                              /*  $this.devices[dKey].files[fKey].slots[count] = file;*/
                                count++;
                            }
                        }
                    }
                }

               /* $('#' + dKey + '' + fKey).modal('hide');
                $('.modal-backdrop').remove();*/
                setTimeout(function() {
                    $this.$forceUpdate();
                }, 2000);
            },
            readFile(file, i) {
                var $this = this;
                var reader = new FileReader();
                reader.onload = function() {
                    var code = reader.result;
                    $this.dFiles[i]['preview'] = code;
                };
                reader.readAsDataURL(file);
            },
            readRemainFile(file,name,slotCount = null) {
                var $this = this;
                var reader = new FileReader();
                reader.onload = function() {
                    var code = reader.result;
                    if (name == 'slot' && slotCount != null) {
                        $this.files.slots[slotCount]['file'] = code;
                        $this.files.slots[slotCount]['name'] = file.name;
                        $this.files.slots[slotCount]['objectPosition'] = 'center';
                        $this.files.slots[slotCount]['imgRoation'] = 0;
                        $this.files.slots[slotCount]['deviceType'] = 'full_device';
                    }else{
                     $this.files[name] = code;
                    }
                };
                reader.readAsDataURL(file);
            },
            sorted: function(event) {},
            setfilesize(file, widthname, hightname) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                        var height = this.height;
                        var width = this.width;
                        console.log(height)
                        $('#' + widthname).val(width);
                        $('#' + hightname).val(height);
                        return true;
                    };
                }
            },
            setinnerData(dkey,fkey,lkey){
                var layer = this.devices[dkey].files[fkey].psd[lkey];
                var layer_name = layer.name.split('-')[0];
                layer_name = layer_name.replace('frame','inner');
                $.each(this.devices[dkey].files[fkey].psd, function(i, l){
                    if (l.name.split('-')[0] == layer_name) {
                        l.deviceType = layer.deviceType;
                        l.objectPosition = layer.objectPosition;
                        l.imgRoation = layer.imgRoation;
                    }
                });
                this.$forceUpdate();
            },
            setcolor(){
                var color = $('#bgColor').val();
                 this.files['bg'] = color;
            },
            extractPSD(dKey, fKey) {
                var $this = this;
                let formData = new FormData();
                formData.append('psd', this.files.psd);
                axios({
                    method: "POST",
                    url: "/upload-psd",
                    data: formData,
                    headers: {
                        "content-type": "application/json"
                    }
                }).then(response => {
                    var response = response.data;
                    console.log(response);
                    var newfilename = '/psd/' + response.filename;
                    PSD.fromURL(newfilename).then(function(psd) {
                        psd.parse();
                         var firsthandPSd = psd;
                        var entry = psd.tree().export();
                        var childers = entry.children;
                        var i=0;
                           $.each(childers, function(chi, ch){
                            var designnode = firsthandPSd.tree().descendants()[i];
                            if (typeof designnode.get('objectEffects') != 'undefined') {

                                var layerStyling = designnode.get('objectEffects').data;
                            } else {
                                var layerStyling = '';
                            }
                            ch.objectPosition = 'center';
                            ch.layerStyling = layerStyling;
                            ch.imgRoation = '0';
                            ch.deviceType = 'full_device';
                            ch.TextCenter = 'center';
                            i++;
                           })
                           console.log(childers);
                        $this.files.psd = childers;
                    });
                });
            },
            submit(){
                var $this = this;
                let formData = new FormData();
                formData.append('category',this.form.category);
                formData.append('title',this.form.title);
                formData.append('type',this.form.type);
                formData.append('orientation',this.form.orientation);
                formData.append('main_img',this.form.main_img);
                var uploadDevices = this.files;
               /* console.log(this.devices);
                return true*/
             /*   $.each(uploadDevices, function(dkey, device){
                    $.each(device.files, function(fkey, file){
                        file.preview = '';
                   })
               })*/
                formData.append('upfiles',JSON.stringify(uploadDevices));
                axios({
                    method: "POST",
                    url: "/upload-template",
                    data: formData,
                    headers: {
                        "content-type": "application/json"
                    }
                }).then(response => {

                 var response = response.data;
                 if (response.status) {
                    this.success_message = response.message;
                    setTimeout(function() {
                      $this.success_message = "";
                  }, 5000);
                 }else{
                     this.error_message = response.message;
                   /* setTimeout(function() {
                      $this.error_message = "";
                  }, 5000);*/
                 }

                });
            }
        }
};
</script>