<template>
  <h2 class="text-center">Characters</h2>

  <div class="row justify-content-center">
    <div
      class="col-12 col-lg-3 my-4"
      v-for="character in characters"
      :key="character.id"
    >
      <div class="card" style="width: 18rem">
        <img
          :src="imageLink(character.className)"
          class="card-img-top p-4"
          alt="..."
        />
        <div class="card-body">
          <h5 class="card-title text-center">{{ character.name }}</h5>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Ilvl: {{ character.ilvl }}</li>
          <li class="list-group-item">Tank: {{ checkbox(character.tank) }}</li>
          <li class="list-group-item">
            Healer: {{ checkbox(character.healer) }}
          </li>
          <li class="list-group-item">DPS: {{ checkbox(character.dps) }}</li>
          <li class="list-group-item">
            Saved: {{ checkbox(character.saved) }}
            <button type="button" class="btn btn-warning" @click="toggleSaved(character.id)">(toggle)</button>
          </li>
        </ul>
        <div class="card-body d-flex justify-content-around">
          <button type="button" class="btn btn-danger" @click="remove(character.id)">Remove</button>
          <button type="button" class="btn btn-primary" @click="update(character.id)">Update</button>
          <!-- <a href="#" class="btn btn-danger" @click="remove(character.id)"
            >Remove</a
          >
          <a href="#" class="btn btn-primary" @click="update(character.id)"
            >Update</a
          > -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Characters",
  props: ["characterList"],

  data() {
    return {
      characters: this.characterList,
    };
  },
  methods: {
    debug() {
      console.log(this.characters);
    },
    checkbox(bool) {
      if (bool) {
        return "✔";
      }
      return "❌";
    },
    imageLink(className) {
      switch (className) {
        case 1:
          return require("../assets/classes/warrior.png");
        case 2:
          return require("../assets/classes/paladin.png");
        case 3:
          return require("../assets/classes/hunter.png");
        case 4:
          return require("../assets/classes/rogue.png");
        case 5:
          return require("../assets/classes/priest.png");
        case 6:
          return require("../assets/classes/deathknight.png");
        case 7:
          return require("../assets/classes/shaman.png");
        case 8:
          return require("../assets/classes/mage.png");
        case 9:
          return require("../assets/classes/warlock.png");
        case 10:
          return require("../assets/classes/monk.png");
        case 11:
          return require("../assets/classes/druid.png");
        case 12:
          return require("../assets/classes/demonhunter.png");
        default:
          return require("../assets/classes/warrior.png");
      }
    },
    update(id) {
      this.$emit("update-character", id);
    },
    remove(id) {
      this.$emit("remove-character", id);
    },
    toggleSaved(id) {
      this.$emit("toggle-saved", id);
    },
  },
  emits: ["update-character", "remove-character", "toggle-saved"],
};
</script>

<style scoped>
.contaier {
  background-color: white;
}

.list {
  background-color: white;
}
</style>