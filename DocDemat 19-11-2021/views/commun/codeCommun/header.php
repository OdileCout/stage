<div class="row hhh">
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