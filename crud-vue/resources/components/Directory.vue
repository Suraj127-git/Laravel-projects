// resources/components/Directory.vue

<template>
    <div>
        <div class="form-group">
            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                placeholder="Enter Name"
                class="form-control"
                v-model="items.name"
            />
        </div>
        <div class="form-group">
            <label for="email">email</label>
            <input
                type="text"
                id="email"
                placeholder="Enter email"
                class="form-control custom-input"
                v-model="items.email"
            />
        </div>
        <button class="btn btn-success btn-block col-md-12" @click="save">
            {{ isEditing ? "Update" : "Save" }}
        </button>
        <div class="col-md-12" v-if="lists.length > 0">
            <h2 class="text-center">Customer Data</h2>
            <ul class="list-group">
                <li
                    class="list-group-item"
                    v-for="item in lists"
                    :key="item.id"
                >
                    {{ item.name }} - {{ item.email }}
                    <span class="float-right">
                        <button
                            class="btn btn-success btn-block"
                            @click="edit_id(item)"
                        >
                            Edit
                        </button>
                        <button
                            class="btn btn-danger btn-block"
                            @click="delete_id(item.id)"
                        >
                            Delete
                        </button>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "Directory",
    data() {
        return {
            lists: [],
            items: {
                name: "",
                email: "",
            },

            temp_id: null,
            isEditing: false,
        };
    },
    mounted() {
        this.fetch_all();
    },
    methods: {
        fetch_all() {
            axios.get("/api/customer").then((response) => {
                this.lists = response.data;
            });
        },
        save() {
            let methods = axios.post;
            let url = "api/customer";
            if (this.isEditing) {
                methods = axios.put;
                url = `api/customer/${this.temp_id}`;
            }

            try {
                methods(url, this.items).then((response) => {
                    this.fetch_all();
                    this.items = {
                        name: "",
                        email: "",
                    };

                    this.temp_id = null;
                    this.isEditing = false;
                });
            } catch (e) {
                console.log(e);
            }
        },
        edit_id(cus_id) {
            // console.log(cus_id);
            this.items = {
                name: cus_id.name,
                email: cus_id.email,
            };
            this.temp_id = cus_id.id;
            this.isEditing = true;
            // this.items.name = this.lists[this.id].name;
            // this.items.email = this.lists[this.id].email;
        },
        delete_id(id) {
            console.log(id);
            try {
                axios
                    .delete(`/api/customer/${id}`)
                    .then((response) => this.fetch_all());
            } catch (e) {
                console.log(e);
            }
        },
    },
};
</script>
