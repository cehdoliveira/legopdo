const { createApp } = Vue;
createApp({
  data() {
    return {
      form: {
        nome: "",
        email: "",
        telefone: "",
        cpf: "",
        btn_save: "btn_save",
      },
    };
  },
  methods: {
    async submitForm() {
      try {
        const formData = new FormData();
        for (const key in this.form) {
          formData.append(key, this.form[key]);
        }
        const response = await fetch("/save", {
          method: "POST",
          body: formData,
        });
        if (response.ok) {
          alert("Cadastro enviado com sucesso!");
        } else {
          alert("Erro ao enviar cadastro.");
        }
      } catch (error) {
        alert("Erro de conexão.");
      }
    },
  },
}).mount("#registerApp");
