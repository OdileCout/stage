<?php
include_once('commun/ent_foot/entete.php');
// include_once('../controllers/AjoutModifCtrl.php');

?>
<div id="q-app" style="min-height: 50vh;">
    <div class="column items-center" style="margin-top:220px;">
        <div class=" col-9 col-md-3 ">
            <q-btn @click="print">
                <qrcode-vue :value="`pageAffichageDoc.php?idCadre=<?php echo $_GET['id']; ?>`" :size="250">
                </qrcode-vue>
            </q-btn>
        </div>
    </div>
</div>
<?php
include_once('commun/ent_foot/footer.php');
?>