<template>
    <div>
        <div class="modal" id="HelpModal">
            <div class="modal-dialog" style="max-width: 85%;">
                <div class="modal-content" style="    overflow-y: hidden;">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <!-- <h4 class="modal-title">How to use</h4> -->

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            How to change background
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                                <p>Click on background option from tools bar or directly click on
                                                    background in canvas</p>
                                                <h6>Add your own image</h6>
                                                <ol>

                                                    <li>Click on 'Select New background' button in editor bar</li>
                                                    <li>Add your image in selection panel</li>
                                                    <li>Press Save at the bottom</li>
                                                    <li>You are good to go</li>
                                                </ol>
                                                <h6>If you just want to add color on background</h6>
                                                <ol>
                                                    <li>First remove image from background by clicking on red clear </li>
                                                    <li>Click on Background style selection in editor bar</li>
                                                    <li>Select Color option form style selection options</li>
                                                    <li>After selecting style a color pelete will open</li>
                                                    <li>Selec your desire color</li>
                                                    <li>You are good to go</li>
                                                </ol>
                                            <!-- <div class="col-md-6">
                                                <img src="/studio/assets/img/info/change-bg.png">
                                            </div> -->
                                            </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            How to edit text
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ol>
                                            <li>Click on text in canvas you want to edit</li>
                                            <li>Layer editor on left will open it which allow you to edit</li>
                                            <li>There is text box on top make change in it</li>
                                            <li>You can also change colors and formating of text including font style</li>
                                            <li>Your good to go</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo2">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="false"
                                            aria-controls="collapseTwo2">
                                            How to add new text
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo2"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ol>
                                            <li>Click on any text in canvas</li>
                                            <li>Layer editor on left will open</li>
                                            <li>In layer editor panel you will see  a 'add new text' button on top</li>
                                            <li>After clicking new text will be shown on top left of canvas. That's it</li>
                                            <li>Your good to go</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            How change colors
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ol>
                                            <li>Click on any Text or Icon. Your want o edit</li>
                                            <li>Layer editor on left will open</li>
                                            <li>You will different color in center of it</li>
                                            <li>Select color from preset colors</li>
                                            <li>Your good to go</li>
                                        </ol>
                                        <h5>Add your own colors</h5>
                                        <ol>
                                            <li>Click on any Text or Icon. Your want o edit</li>
                                            <li>Layer editor on left will open</li>
                                            <li>Under new colors heading in center of panel. Your will see first option with '+' mark. Click on it</li>
                                            <li>Add your colors from pelete and click on 'save'</li>
                                            <li>Your good to go</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading4">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapse4" aria-expanded="false"
                                            aria-controls="collapse4">
                                            How to change images
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse4" class="collapse" aria-labelledby="heading4"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ol>
                                            <li>Click on image your want from canvas</li>
                                            <li>Layer editor on left will open</li>
                                            <li>Click on 'Select New Image' button in editor bar</li>
                                            <li>Add your image in selection panel</li>
                                            <li>Press Save at the bottom</li>
                                            <li>You are good to go</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading5">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapse5" aria-expanded="false"
                                            aria-controls="collapse5">
                                            How to undo or redo changes
                                        </button>
                                    </h2>
                                    
                                </div>
                                <div id="collapse5" class="collapse" aria-labelledby="heading5"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <h5>With keys</h5>
                                        <ol>
                                            <li>Ctrl + z to undo</li>
                                            <li>Ctrl + y to redo</li>
                                        </ol>
                                        <h5>With buttons</h5>
                                        <ol>
                                            <li>On your top view in header you will see to icon in center of it</li>
                                            <li>Left circle arrow icon is for undo</li>
                                            <li>Right circle arrow icon is for redo</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading6">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapse6" aria-expanded="false"
                                            aria-controls="collapse6">
                                            How to add Shapes
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse6" class="collapse" aria-labelledby="heading6"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ol>
                                            <li>Click on shapes option from tools bar on left side</li>
                                            <li>Shapes options panel will open</li>
                                            <li>Search and find your desired shape</li>
                                            <li>Click on shape you like</li>
                                            <li>After clicking shape will be add to canvas on top left. Thats it</li>
                                            <li>Your good to go</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading7">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapse7" aria-expanded="false"
                                            aria-controls="collapse7">
                                            How to download
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse7" class="collapse" aria-labelledby="heading7"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <ol>
                                            <li>After completing your editing</li>
                                            <li>You will find download button on top right of header. Click on it</li>
                                            <li>After clicking you will format option. Click on your desired format</li>
                                            <li>That's it you design will start downling</li>
                                        </ol>
                                        <p>Thanks for choosing us. Please let us know if you find any difficulties in process</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">

                        <button type="button" class=" btn-none float-right" v-on:click="setintro('1')"><b>Close</b></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stepcount: 1,
        }
    },
    mounted() {

    },

    methods: {
        setstep(c) {
            this.stepcount = c;
        },
        movetonext() {
            this.stepcount = parseInt(parseInt(this.stepcount) + 1);
            this.$forceUpdate();
        },
        setintro(status) {

            this.$store.commit('set_intro', status);
            $('#HelpModal').modal('hide');
            $('.modal-backdrop').remove();
        }
    },
}
</script>