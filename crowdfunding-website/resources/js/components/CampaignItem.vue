<template>
    <div>
        <v-card :to="'/campaign/'+campaign.id">
            <v-img
                :src="campaign.image"
                class="white--text"
                height="200px"
            >
                <v-card-title
                    class="fill-height align-end"
                    v-text="campaign.title"
                ></v-card-title>
            </v-img>

            <v-card-actions>
                <v-progress-linear
                    color="indigo darken-2"
                    rounded
                    height="7"
                    v-model="progres"
                ></v-progress-linear>
            </v-card-actions>

            <v-card-actions>
                <v-icon>mdi-cash</v-icon>
                <span> Rp {{ campaign.required.toLocaleString('id-ID') }}</span>
                <v-spacer></v-spacer>
                <span> {{ progres + '%' }} </span>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>

export default {
    name: 'campaign-item',
    props: ['campaign'],
    computed:{
        progres() {
            return Math.floor(this.campaign.collected / this.campaign.required * 100)
        }
    }

}
</script>
