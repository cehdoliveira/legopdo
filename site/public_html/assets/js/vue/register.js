const { createApp } = Vue;
createApp({
  data() {
    return {
      form: {
        name: "",
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
        const data = await response.json();
        if (response.ok && data.success) {
          alert(data.message);
          // Limpar formulário após sucesso
          this.form.name = "";
          this.form.email = "";
          this.form.telefone = "";
          this.form.cpf = "";
        } else {
          alert(data.message || "Erro ao enviar cadastro.");
        }
      } catch (error) {
        alert("Erro de conexão.");
      }
    },
  },
}).mount("#registerApp");
