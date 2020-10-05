<template>
  <h2 class="text-center">Add/update character <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#update-character" aria-expanded="false" aria-controls="update-character">
    +
  </button>
  </h2>
  <div class="row justify-content-center collapse" id="update-character"> 
    <div class="col-8">
      <form @submit="addOrUpdate">
        <div class="mb-3">
          <label for="name" class="form-label">Character name</label>
          <input type="text" class="form-control" id="name" v-model="name" required="required">
        </div>

        <div class="mb-3">
          <label for="ilvl" class="form-label">Ilvl</label>
          <input type="text" class="form-control" id="ilvl" v-model="ilvl" required="required">
        </div>

        <div class="mb-3">
          <label for="server" class="form-label">Server</label>
          <input type="text" class="form-control" id="server" v-model="server" required="required">
        </div>

        <div class="mb-3">
          <label for="class" class="form-label">Select class</label>
          <select id="class" class="form-select" aria-label="Default select example" v-model="className" required="required"> 
            <option value="0">Druid</option>
            <option value="1">Paladin</option>
            <option value="2">Warrior</option>
            <option value="3">Demon Hunter</option>
            <option value="4">Hunter</option>
            <option value="5">Mage</option>
            <option value="6">Rogue</option>
            <option value="7">Death Knight</option>
            <option value="8">Priest</option>
            <option value="9">Warlock</option>
            <option value="10">Shaman</option>
            <option value="11">Monk</option>
          </select>
        </div>

        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="role_tank" v-model="tank">
          <label class="form-check-label" for="role_tank">Tank</label>
        </div>

        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="role_healer" v-model="healer">
          <label class="form-check-label" for="role_healer">Healer</label>
        </div>

        <div class="mb-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="role_dps" v-model="dps">
            <label class="form-check-label" for="role_dps">Dps</label>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <!-- <button type="button" @click="debug()" class="btn btn-primary">Debug</button> -->
      </form>
    </div>
  </div>

</template>

<script>
  export default {
    name: 'AddNewCharacter',
    components: {},
    data() {
      return {
        id: Math.floor(Math.random()*133769),
        name: '',
        server: '',
        className: '',
        ilvl: 0,
        tank: false,
        healer: false,
        dps: false,
        saved: false
      }
    },
    methods: {
      addOrUpdate(e){
        this.$emit('save-character', {
          id: this.id,
          name: this.name,
          server: this.server,
          ilvl: this.ilvl,
          className: this.className,
          tank: this.tank,
          healer: this.healer,
          dps: this.dps,
          saved: this.saved
        })
        e.preventDefault();
        return false;
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  h3 {
    margin: 40px 0 0;
  }

  ul {
    list-style-type: none;
    padding: 0;
  }

  li {
    display: inline-block;
    margin: 0 10px;
  }

  a {
    color: #42b983;
  }
</style>