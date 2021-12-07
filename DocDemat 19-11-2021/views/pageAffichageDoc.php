<?php
include_once('commun/ent_foot/entete.php');
//   if (!isset($_GET['idCadre'])){
//     header('Location: AccAdmin.php');
?>
<!-- <div>
    <input type="text" onchange="window.location.href ='pageAffichageDoc.php?idCadre='+this.value">blabla</input>
</div> -->
<?php
// exit;
// }
?>
<div id="q-app" style="min-height: auto;">
    <div class="q-pa-md" style="min-height: auto;">
        <div class="row">
            <div class="col-3 col-md-3">
                <div class="col-12 col-md-4" style="width: 70%;">
                    <q-img style="min-height: 10%;" src="assets/img/logoFm.png"></q-img>
                </div>
            </div>
        </div>
        <div class="row pageScan">
            <div class="col-12 col-md-12 affichage" style="width: 90%;">
                <div class="col-12 col-md-12" style="width: 100%;">
                    <div class="q-pa-md">
                        <q-carousel swipeable animated transition-next="slide-left" animated v-model="slide"
                            :autoplay="autoplay" ref="carousel" infinite fullscreen style="height: 100vh">
                            <q-carousel-slide v-for="rrr in docVisionnerValide" :name="rrr">
                                <q-img v-if="rrr.types == 'image'" style="width:100%" :src="urlImgDoc+rrr.chemin">
                                </q-img>
                                <q-video v-else-if="rrr.types == 'documents'" class="absolute-full"
                                    :src="urlImgDoc+rrr.chemin"></q-video>
                                <q-video v-else-if="rrr.types == 'video'" class="absolute-full" :src="rrr.chemin">
                                </q-video>
                            </q-carousel-slide>
                            <template v-slot:control>
                                <div class="row" v-for="ddd in docVisionnerValide">
                                    <div v-if="ddd.diaporama == 1" class="col">
                                        <q-carousel-control :offset="[18, 18]" class="text-white rounded-borders "
                                            style="background: rgba(0, 0, 0, .3); padding: 4px 8px;">
                                            <q-toggle dense dark color="primary" v-model="autoplay" label="Auto Play">
                                            </q-toggle>
                                        </q-carousel-control>
                                    </div>
                                    <div v-else class="col">
                                        <q-carousel-control position="bottom-left" :offset="[18, 18]"
                                            class="q-gutter-xs">
                                            <q-btn push round dense color="blue-8" text-color="black" icon="arrow_left"
                                                @click="$refs.carousel.previous()"></q-btn>
                                            <q-btn push round dense color="blue-8" text-color="black" icon="arrow_right"
                                                @click="$refs.carousel.next()"></q-btn>
                                        </q-carousel-control>
                                    </div>
                                </div>
                            </template>
                        </q-carousel>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const PHP_ID = <?= $_GET['idCadre'] ?>;
</script>
<?php
include_once('commun/ent_foot/footer.php');
?>