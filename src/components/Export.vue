<template>
  <div class="mb-3">
    <button class="btn btn-primary mb-3" type="button" @click="copyText">
      Copy text
    </button>

    <button
      class="btn btn-primary mb-3 ml-3"
      type="button"
      @click="toggleExportFormat"
    >
      Toggle between horizontal / vertical display
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
      return this.characters.length * 2 + 3;
    },
    textarea() {

      let filteredCharacters =  this.characters.filter(char => !char.saved)

      let value = "";
      let roles = ["Role"].concat(
        filteredCharacters.map((char) => {
          let r = [];
          if (char.tank) r.push("Tank");
          if (char.healer) r.push("Healer");
          if (char.dps) r.push("Dps");
          return r.join("/");
        })
      );
      let classes = ["Class"].concat(
        filteredCharacters.map((char) => this.classNameFromId(char.className))
      );
      let ilvls = ["Ilvl"].concat(filteredCharacters.map((char) => char.ilvl));
      let logs = ["Logs"].concat(
        filteredCharacters.map((char, index) => index + 1)
      );
      let saved = ["Saved"].concat(
        filteredCharacters.map((char) => (char.saved ? "yes" : "no"))
      );

      if (this.vertical) {
        value += this.classListToStringVertical(
          roles,
          classes,
          ilvls,
          logs,
          saved
        );
      } else {
        value += this.classListToStringHorizontal(
          roles,
          classes,
          ilvls,
          logs,
          saved
        );
      }

      for (let i = 0; i < filteredCharacters.length; i++) {
        const char = filteredCharacters[i];

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
      id = Number.parseInt(id);
      switch (id) {
        case 1:
          return "Warrior";
        case 2:
          return "Paladin";
        case 3:
          return "Hunter";
        case 4:
          return "Rogue";
        case 5:
          return "Priest";
        case 6:
          return "DK";
        case 7:
          return "Shaman";
        case 8:
          return "Mage";
        case 9:
          return "Warlock";
        case 10:
          return "Monk";
        case 11:
          return "Druid";
        case 12:
          return "DH";
        default:
          return "Pepega";
      }
    },

    toggleExportFormat() {
      this.vertical = !this.vertical;
    },

    classListToStringVertical(roles, classes, ilvls, logs, saved) {
      let value = "```";
      value +=
        "\n" +
        roles
          .map((role, i) =>
            role.padEnd(
              Math.max(
                ...[
                  roles[i].length,
                  classes[i].length,
                  (ilvls[i] + "").length,
                  (logs[i] + "").length,
                  saved[i].length,
                ]
              ) + 1,
              " "
            )
          )
          .join("| ");
      value +=
        "\n" +
        ilvls
          .map((ilvl, i) =>
            (ilvl + "").padEnd(
              Math.max(
                ...[
                  roles[i].length,
                  classes[i].length,
                  (ilvls[i] + "").length,
                  (logs[i] + "").length,
                  saved[i].length,
                ]
              ) + 1,
              " "
            )
          )
          .join("| ");
      value +=
        "\n" +
        classes
          .map((className, i) =>
            className.padEnd(
              Math.max(
                ...[
                  roles[i].length,
                  classes[i].length,
                  (ilvls[i] + "").length,
                  (logs[i] + "").length,
                  saved[i].length,
                ]
              ) + 1,
              " "
            )
          )
          .join("| ");
      value +=
        "\n" +
        logs
          .map((log, i) =>
            (log + "").padEnd(
              Math.max(
                ...[
                  roles[i].length,
                  classes[i].length,
                  (ilvls[i] + "").length,
                  (logs[i] + "").length,
                  saved[i].length,
                ]
              ) + 1,
              " "
            )
          )
          .join("| ");
      value +=
        "\n" +
        saved
          .map((save, i) =>
            save.padEnd(
              Math.max(
                ...[
                  roles[i].length,
                  classes[i].length,
                  (ilvls[i] + "").length,
                  (logs[i] + "").length,
                  saved[i].length,
                ]
              ) + 1,
              " "
            )
          )
          .join("| ");
      value += "\n```";

      return value;
    },
    classListToStringHorizontal(roles, classes, ilvls, logs, saved) {
      let value = "```";

      for (let i = 0; i < roles.length; i++) {
        value += "\n";
        value +=
          roles[i].padEnd(
            Math.max(...roles.map((role) => role.length)) + 1,
            " "
          ) + "| ";
        value +=
          (ilvls[i] + "").padEnd(
            Math.max(...ilvls.map((ilvl) => (ilvl + "").length)) + 1,
            " "
          ) + "| ";
        value +=
          classes[i].padEnd(
            Math.max(...classes.map((className) => className.length)) + 1,
            " "
          ) + "| ";
        value +=
          (logs[i] + "").padEnd(
            Math.max(...logs.map((log) => (log + "").length)) + 1,
            " "
          ) + "| ";
        value += saved[i];
      }

      value += "\n```";
      return value;
    },
  },
};
</script>

<style scoped>
textarea {
  font-family: "Courier New", Courier, monospace;
}
</style>