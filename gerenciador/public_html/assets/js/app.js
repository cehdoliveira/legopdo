const { createApp } = Vue;

createApp({
  data() {
    return {
      newItem: "",
      items: [],
    };
  },
  methods: {
    addItem() {
      if (this.newItem.trim()) {
        this.items.push(this.newItem.trim());
        this.newItem = "";
      }
    },
    removeItem(index) {
      this.items.splice(index, 1);
    },
  },
}).mount("#app");
