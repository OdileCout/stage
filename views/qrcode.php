<?php
include_once('commun/ent_foot/entete.php');
// include_once('../controllers/AjoutModifCtrl.php');

?>
<div id="q-app" style="min-height: 100vh;">
    <!-- <div class="col-6 col-md-4 " v-for="cadre in currentIcones"> -->
    <div class="column items-center" style="margin-top:220px;">
        <div class=" col-9 col-md-3 ">
            <q-btn @click="print" class="bg-primary">
                <qrcode-vue value="<?php echo $_GET['id'];?>" :size="250">
                </qrcode-vue>
                <div><?php echo $_GET['id'];?></div>
            </q-btn>
        </div>
    </div>
    <!-- </div> -->
</div>
<?php 
 include_once('commun/ent_foot/footer.php');
?>

</body>

</html>