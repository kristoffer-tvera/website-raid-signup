<template>

<h2 class="text-center" >Characters</h2>

<div class="row justify-content-center">
  <div class="col-12 col-lg-3 my-4" v-for="(character) in characters" :key="character.id">
    <div class="card" style="width: 18rem;">
  <img :src="imageLink(character.className)" class="card-img-top p-4" alt="...">
  <div class="card-body">
    <h5 class="card-title text-center">{{character.name}}</h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Ilvl: {{character.ilvl}}</li>
    <li class="list-group-item">Tank: {{checkbox(character.tank)}}</li>
    <li class="list-group-item">Healer: {{checkbox(character.healer)}}</li>
    <li class="list-group-item">DPS: {{checkbox(character.dps)}}</li>
  </ul>
  <div class="card-body d-flex justify-content-around">
    <a href="#" class="btn btn-danger">Remove</a>
    <a href="#" class="btn btn-primary">Update</a>
  </div>
</div>
  </div>
</div>


</template>

<script>
export default {
  name: 'Characters',
  props: ['characterList'],
  data() {
    return {
      characters: this.characterList
    }
  },
  methods: {
    debug(){
      console.log(this.characters);
    },
    checkbox(bool){
      if(bool){
        return '✔';
      }
      return '❌';
    },
    imageLink(className){
      return require('../assets/classes/' + className + '.png');
    }
  }
}
</script>

<style scoped>
.contaier{
  background-color: white;
}
.list{
  background-color: white;
}
</style>
