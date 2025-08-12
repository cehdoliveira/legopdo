<!-- Main content com Vue mounting point -->
<main id="app" class="container">
    <!-- Exemplo de componente simples -->
    <section class="mb-5">
        <h2 class="h4 mb-3">To-Do List</h2>
        <form @submit.prevent="addItem" class="input-group mb-3">
            <input
                v-model="newItem"
                type="text"
                class="form-control"
                placeholder="Nova tarefa"
                required />
            <button class="btn btn-success" type="submit">Adicionar</button>
        </form>

        <ul class="list-group">
            <li
                v-for="(item, idx) in items"
                :key="idx"
                class="list-group-item d-flex justify-content-between align-items-center">
                {{ item }}
                <button class="btn btn-sm btn-outline-danger" @click="removeItem(idx)">
                    &times;
                </button>
            </li>
        </ul>
    </section>
    <section>
        <h2 class="h4 mb-3">Usuários Ativos</h2>
        <ul class="list-group">
            <li
                v-for="user in users"
                :key="user.idx"
                class="list-group-item d-flex justify-content-between align-items-center">
                {{ user.name }} ({{ user.email }})
                <span class="badge bg-primary rounded-pill">{{ user.cpf }}</span>
            </li>
        </ul>
    </section>
</main>