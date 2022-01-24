<template>
    <v-container class="ma-0 pa-0" grid-list-sm>
        <div class="text-right">
            <v-btn small text to="/campaigns" class="blue--text">
                All Campaign <v-icon>mdi-chevron-right</v-icon>
            </v-btn>
        </div>
        <v-layout wrap>
            <v-flex v-for="(campaign, index) in campaigns" :key="`campaign-`+campaign.id" xs6>
                <campaign-item :campaign="campaign" />
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import CampaignItem from '../components/CampaignItem.vue'

export default {
    data: () => ({
        campaigns : []
    }),
    components: {
        CampaignItem
    },
    created() {
        axios.get('api/campaign/random/2')
            .then((response) => {
                let { data } = response.data
                this.campaigns = data.campaigns
            })
            .catch((error) => {
                let { response } = error
                console.log(response)
            })
    }
}
</script>
