
<?php 
  include_once('commun/ent_foot/entete.php');
?>
  <div id="q-app" style="min-height: 100vh;">
    <div class="q-pa-md corps" style="min-height: 90vh;">
      <div class="row">
        <div class="col-3 col-md-3">
            <div class="col-12 col-md-4" style="width: 70%;">
                <q-img style="min-height: 10%;" src="assets/img/logoFm.png"></q-img>
            </div>
        </div>
        <div class="col-9 col-md-9">
            <q-input dark dense standout v-model="text" input-class="text-center" class="q-ml-md bg-primary">
                <span class="material-icons-outlined search">
                  <q-icon v-if="text === ''" name="search"></q-icon>
                  <q-icon v-else name="clear" class="cursor-pointer" @click="text = ''"></q-icon>
                </span>
            </q-input>
        </div>
      </div>
      <div class="row pageScan">
        <div class="col-3 col-md-3"></div>
        <div class="col-9 col-md-9 scan" style="height: 75vh; width: 70%">
          <div class="col-12 col-md-12 scan"  style="height:70%; width: 90%;">
            <div style="height: 100%; width: 50%;" class="bg-primary">
              <q-img  class="image" src="assets/img/qrcode.png"></q-img>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php 
  include_once('commun/ent_foot/footer.php');
?>


