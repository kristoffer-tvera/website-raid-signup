<template>
  <div class="mb-3">
    <button class="btn btn-primary mb-3" type="button" @click="copyText">
      Copy text
    </button>
    <label for="export-area" class="form-label sr-only">Example textarea</label>
    <textarea
      class="form-control"
      id="export"
      :rows="rows"
      readonly="readonly"
      v-model="textarea"
    ></textarea>
    <button class="btn btn-primary mt-3" type="button" @click="copyText">
      Copy text
    </button>
  </div>
</template>

<script>
export default {
  name: "Export",
  props: ["characterList"],
  data() {
    return {
      characters: this.characterList,
      vertical: false,
    };
  },
  computed: {
    rows() {
      return (this.characters.length * 2) + 3;
    },
    textarea() {
      let value = "";

      if (this.vertical) {
        value += "```";

        value += "\nRole :";
        value += "\nClass:";
        value += "\nilvl :";
        value += "\nLogs :";
        value += "\nSaved:";

        value += "\n```";
        value += "\n(n): https://www.warcraftlogs.com/character/eu/draenor/jsl";

        return value;
      } else {
        value += "```";

        let roles = ["Role"];
        let ilvls = ["Ilvl"];
        let classes = ["Class"];
        let logs = ["Logs"];
        let saved = ["Saved"];

        let index = 1;
        this.characters.forEach((char) => {
          if (char.name.length === 0) return;

          let charRoles = [];
          if (char.tank) charRoles.push("Tank");
          if (char.healer) charRoles.push("Heal");
          if (char.dps) charRoles.push("Dps");

          let role = charRoles.join("/");

          roles.push(role);
          ilvls.push(char.ilvl);
          classes.push(this.classNameFromId(char.className));
          logs.push("(" + index++ + ")");
          if (char.saved) {
            saved.push("yes");
          } else {
            saved.push("no");
          }
        });

        for (let i = 0; i < index; i++) {
          value += "\n";
          value +=
            roles[i].padEnd(
              Math.max(...roles.map((role) => role.length)) + 1,
              " "
            ) + "| ";
          value +=
            (ilvls[i] + '').padEnd(
              Math.max(...ilvls.map((ilvl) => ilvl.length)) + 1,
              " "
            ) + "| ";
          value +=
            classes[i].padEnd(
              Math.max(...classes.map((className) => className.length)) + 1,
              " "
            ) + "| ";
          value +=
            logs[i].padEnd(
              Math.max(...logs.map((log) => log.length)) + 1,
              " "
            ) + "| ";
          value += saved[i];
        }

        value += "\n```";
      }

      for (let i = 0; i < this.characters.length; i++) {
        const char = this.characters[i];

        let server = char.server.toLowerCase().replace(" ", "-");
        let name = char.name.toLowerCase();

        value +=
          "\n(" +
          (i + 1) +
          "): https://www.warcraftlogs.com/character/eu/" +
          server +
          "/" +
          name;
      }

      return value;
    },
  },
  methods: {
    copyText() {
      let textArea = document.querySelector("#export");
      if (textArea) {
        try {
          textArea.select();
          var successful = document.execCommand("copy");
          var msg = successful ? "successful" : "unsuccessful";
          alert("Testing code was copied " + msg);
        } catch (err) {
          alert("Oops, unable to copy");
        }
      }
    },
    classNameFromId(id) {
      switch (id) {
        case "0":
          return "Druid";
        case "1":
          return "Paladin";
        case "2":
          return "Warrior";
        case "3":
          return "Demon Hunter";
        case "4":
          return "Hunter";
        case "5":
          return "Mage";
        case "6":
          return "Rogue";
        case "7":
          return "Death Knight";
        case "8":
          return "Priest";
        case "9":
          return "Warlock";
        case "10":
          return "Shaman";
        case "11":
          return "Monk";
        default:
          return "Pepega";
      }
    },
  },
};
</script>

<style scoped>
textarea {
  font-family: "Courier New", Courier, monospace;
}
</style>