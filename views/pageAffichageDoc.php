<?php 
  include_once('commun/ent_foot/entete.php');
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
                    <q-carousel 
                      swipeable
                      animated
                      v-model="slide"
                      :autoplay="autoplay"
                      ref="carousel"
                      infinite
                      style="height: 100vh">
                      <q-carousel-slide v-for="rrr in docVisionner" :name="rrr">
                        <q-video class="absolute-full" :src="urlImgIcone+rrr.chemin"></q-video>
                      </q-carousel-slide>
                      <template v-slot:control>
                        <q-carousel-control
                          position="top-right"
                          :offset="[18, 18]"
                          class="text-white rounded-borders"
                          style="background: rgba(0, 0, 0, .3); padding: 4px 8px;"
                        >
                          <q-toggle dense dark color="orange" v-model="autoplay" label="Auto Play"></q-toggle>
                        </q-carousel-control>
                      </template>
                    </q-carousel>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    const PHP_ID = <?=$_GET['idCadre'];?>;
</script>
<?php 
  include_once('commun/ent_foot/footer.php');
?>