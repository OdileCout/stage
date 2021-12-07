<?php 
  include_once('commun/ent_foot/entete.php');
 
?>
<div id="q-app" style="min-height: 100vh;">
    <div class="q-pa-md " style="min-height: 90vh;">
        <div class="row">
            <div class="col-3 col-md-3">
                <div class="col-12 col-md-4" style="width: 70%;">
                    <q-img style="min-height: 10%;" src="assets/img/logoFm.png"></q-img>
                </div>
            </div>
            <div class="col-9 col-md-9">
                <div class="col-12 col-md-12 recherche">
                    <q-input type="search" outlined color="primary" debounce="300" v-model="searchCadre">
                        <!-- <q-input filled v-model="text" label="Rechercher" style="width: 30%;" /> -->
                        <span class="material-icons-outlined btnColor">
                            <q-icon v-if="text === ''" name="search"></q-icon>
                            <q-icon v-else name="search" class="cursor-pointer" @click="text = ''"></q-icon>
                        </span>
                    </q-input>
                </div>
            </div>
        </div>
        <div class="row grillCadre">
            <div class="col-6 col-md-4 " v-for="cadre in filteredCadres">
                <div class="add">
                    <div class="row">
                        <div class="printQrCode col-6 col-md-6 ">
                            <p class="namecadre">{{cadre.nom}}<br /></p>
                            <q-btn class="bg-primary">
                            <a :href="`QrCodePrint.php?id=${cadre.id}`" target="_blank">                           
                                <qrcode-vue :value=`pageAffichageDoc.php?idCadre=${cadre.id}` :size="50">
                                </qrcode-vue>   
                            </a>
                            </q-btn>
                        </div>
                        <div class="col-6 col-md-6">
                            <q-img :src="urlImgIcone+cadre.image" style="width: 83%"></q-img>
                        </div>
                        <!-- <div class="col-6 col-md-6" v-else>
                            <q-img :src="urlImgIcone+deee.png" style="width: 83%"></q-img>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="q-pa-lg flex flex-center">
        <q-pagination v-model="current" :max="paginationMax" :max-pages="5" direction-links>
        </q-pagination>
    </div>
</div>
<?php 
    include_once('commun/ent_foot/footer.php');
?>