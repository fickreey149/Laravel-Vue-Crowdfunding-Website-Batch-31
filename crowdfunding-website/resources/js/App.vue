<template>
    <v-app>

      <alert />

      <keep-alive>
        <v-dialog v-model="dialog" fullscreen hide-overlay persistent transition="scale-transition">
          <component :is="currentComponent" @closed="setDialogStatus"></component>
        </v-dialog>
      </keep-alive>

      <v-navigation-drawer app v-model="drawer">
        <v-list>
          <v-list-item v-if="!guest">
            <v-list-item-avatar>
              <v-img :src="user.user.photo"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title>{{ user.user.name }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <div class="pa-2" v-if="guest">
            <v-btn block color="primary" class="mb-1" @click="setDialogComponent('login')">
              <v-icon left>mdi-lock</v-icon>
              Login
            </v-btn>
            <v-btn block color="success">
              <v-icon left>mdi-account</v-icon>
              Register
            </v-btn>
          </div>

          <v-divider></v-divider>

          <v-list-item
            v-for="(item, index) in menus"
            :key="`menu-`+index"
            :to="item.route"
          >
            <v-list-item-icon>
              <v-icon left>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <template v-slot:append v-if="!guest">
          <div class="pa-2">
            <v-btn block color="red" dark @click="logout">
              <v-icon left>mdi-lock</v-icon>
              Logout
            </v-btn>
          </div>
        </template>
      </v-navigation-drawer>

      <v-app-bar app color="success" dark v-if="isHome">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>MCI Crowdfunding</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
          <v-badge color="orange" overlap v-if="transactions > 0">
            <template v-slot:badge>
              <span>{{ transactions }}</span>
            </template>
            <v-icon>mdi-cash-multiple</v-icon>
          </v-badge>

          <v-icon v-else>mdi-cash-multiple</v-icon>

        </v-btn>

        <v-text-field
          slot="extension"
          hide-details
          append-icon="mdi-microphone"
          flat
          label="Search"
          preper-inner-icon="mdi-magnify"
          solo-inverted
          @input="setDialogComponent('search')"
          @click="setDialogComponent('search')"
        >
        </v-text-field>
        
      </v-app-bar>

      <v-app-bar app color="success" dark v-else>
        <v-btn icon @click.stop="$router.go(-1)">
          <v-icon>mdi-arrow-left-circle</v-icon>
        </v-btn>

        <v-toolbar-title>MCI Crowdfunding</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
          <v-badge color="orange" overlap v-if="transactions > 0">
            <template v-slot:badge>
              <span>{{ transactions }}</span>
            </template>
            <v-icon>mdi-cash-multiple</v-icon>
          </v-badge>

          <v-icon v-else>mdi-cash-multiple</v-icon>

        </v-btn>
      </v-app-bar>

      <!-- Sizes your content based upon application components -->
      <v-main>
        <!-- Provides the application the proper gutter -->
        <v-container fluid>
        
          <!-- If using vue-router -->
          <v-slide-y-transition>

            <router-view></router-view>

          </v-slide-y-transition>
        </v-container>
      </v-main>

      <v-card>
        <v-footer absolute app>
          <v-card-text class="text-center">
            &copy; {{ new Date().getFullYear() }} - <strong>Majelis Coding Indonesia</strong>
          </v-card-text>
        </v-footer>
      </v-card>
      
    </v-app>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import Alert from './components/Alert.vue'
  import Search from './components/Search.vue'
  import Login from './components/Login.vue'

  export default {
  
    name: 'App',
    components : {
      Alert,
      Search,
      Login
    },
    data: () => ({
      drawer : false,
      menus : [
        { title: 'Home', icon: 'mdi-home', route: '/'},
        { title: 'Campaign', icon: 'mdi-hand-heart', route: '/campaigns'},
        { title: 'Donation', icon: 'mdi-gift', route: '/donations'}
      ]
    }),
    computed: {
      isHome () {
        return ( this.$route.path === '/' || this.$route.path === '/home')
      },
      ...mapGetters({
        transactions : 'transaction/transactions',
        guest : 'auth/guest',
        user : 'auth/user',
        dialogStatus : 'dialog/status',
        currentComponent : 'dialog/component'
      }),
      dialog : {
        get() {
          return this.dialogStatus
        },
        set(value) {
          return this.setDialogStatus(value)
        }
      }
    },
    methods : {
      ...mapActions({
        setDialogStatus : 'dialog/setStatus',
        setDialogComponent : 'dialog/setComponent',
        setAuth : 'auth/set',
        checkToken : 'auth/checkToken',
        setAlert : 'alert/set'
      }),
      logout() {
        let config = {
          headers : {
            Authorization : `Bearer ${this.user.token}`
          }
        }
        
        axios.post('/api/logout', {}, config)
        .then((response) => {
          this.setAuth({})
          this.setAlert({
            status : true,
            color : 'success',
            text : 'Logout Successfully'
          })
        })
        .catch((error) => {
          let {data} = error.response
          setAlert({
            status : true,
            color : 'error',
            text : data.message
          })
        })
      }
    },
    // mounted(){
    //   if (this.user) {
    //     this.checkToken(this.user)
    //   }
    // }
  }
</script>
