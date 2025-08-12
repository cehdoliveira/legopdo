const { createApp } = Vue;

createApp({
  data() {
    return {
      newItem: "",
      items: [],
      users: [], // Adicionando a propriedade users
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
    async fetchUsers() {
      try {
        const settings = {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
        };

        const response = await fetch("/list-users", settings);

        if (!response.ok) {
          throw new Error("Falha ao carregar dados da API");
        }

        const apiResponse = await response.json();
        this.users = apiResponse.data;
      } catch (error) {
        console.error("Erro ao buscar usuários:", error);
      } finally {
        this.carregando = false;
      }
    },
  },
  mounted() {
    this.fetchUsers(); // Buscar os usuários ao montar o componente
  },
}).mount("#app");
