<template>
    <div>
        <v-card v-if="campaign.id">
            <v-img
                :src="campaign.image"
                class="white--text"
                max-height="500px"
            >
                <v-card-title
                    class="fill-height align-end"
                    v-text="campaign.title"
                ></v-card-title>
            </v-img>

            <v-card-text>
                <v-simple-table dense>
                    <tbody>
                        <tr>
                            <td><v-icon>mdi-home-city</v-icon> Alamat</td>
                            <td>{{ campaign.address }}</td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-hand-heart</v-icon> Terkumpul</td>
                            <td class="blue--text">Rp {{ campaign.collected.toLocaleString('id-ID') }}</td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-cash</v-icon> Dibutuhkan</td>
                            <td class="orange--text">Rp {{ campaign.required.toLocaleString('id-ID') }}</td>
                        </tr>
                    </tbody>
                </v-simple-table>
                Description : <br>
                {{ campaign.description }}
            </v-card-text>

            <v-card-actions>
                <v-btn block color="primary" @click="donate" :disabled="campaign.collected >= campaign.required">
                    <v-icon>mdi-money</v-icon>&nbsp;
                    DONATE
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import { mapMutations, mapActions } from 'vuex'

export default {
    data: () => ({
        campaign: {}
    }),
    created() {
        this.go()
    },
    methods: {
        go(){
            let {id} = this.$route.params

            var config = {
              method: 'get',
              url: `/api/campaign/${id}`
            };

            axios(config)
                .then((res) => {
                    let { data } = res.data
                    this.campaign = data.campaign
                })
                .catch((error) => {
                    let { response } = error
                    console.log(response)
                })
        },

        ...mapMutations({
            tambahTransaksi : 'transaction/insert'
        }),

        ...mapActions({
            setAlert : 'alert/set'
        }),

        donate(){
            this.tambahTransaksi()
            this.setAlert({
                status : true,
                color : 'success',
                text : 'Transaksi berhasil ditambahkan'
            })
        }
    }
}
</script>
