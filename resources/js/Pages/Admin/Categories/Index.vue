<template>
    <admin-layout>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dar">Manajemen Kategori</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <inertialink :href="route('admin.dashboard.index')">Home</inertialink>
                            </li>
                            <li class="breadcrumb-item active">Kategori</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Form Input -->
                    <div class="col-md-4">
                        <form @submit.prevent="checkMode">
                            <div class="form-group">
                                <label for="name">Kategori</label>
                                <input type="text" name="name" id="name" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.name}" autocomplete="off" required="required">
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" v-model="form.description" cols="5" rows="6" class="form-control" :class="{ 'is-invalid': form.errors.description}"></textarea>
                            </div>
                            <div class="footer">
                                <button type="submit" class="btn btn-info text-uppercase" style="letter-spacing: 0.1em;">{{ buttonText }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- End Form -->
                    <!-- Table Category -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Deskripsi</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-if="categories.length > 1">
                                            <tr v-for="category in categories" :key="category.id">
                                                <td>{{ category.name }}</td>
                                                <td>{{ category.description }}</td>
                                                <td class="text-right">
                                                    <button
                                                    type="button"
                                                    class="btn btn-success text-uppercase"
                                                    style="letter-spacing: 0.1em"
                                                    @click="editForm(category)"
                                                    >
                                                    Edit
                                                    </button>
                                                    <button
                                                    type="button"
                                                    class="btn btn-danger text-uppercase ml-1"
                                                    style="letter-spacing: 0.1em"
                                                    @click="deleteCategory(category)"
                                                    >
                                                    Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                            <tr v-else>
                                                <td colspan="3" class="text-center">
                                                    Belum Ada Data
                                                </td>
                                            </tr>
                                        <!-- <tr v-for="(category, index) in categories.data" :key="index">
                                                <td>{{ category.name }}</td>
                                                <td>{{ category.description }}</td>
                                                <td class="text-right">
                                                    <button
                                                    type="button"
                                                    class="btn btn-success text-uppercase"
                                                    style="letter-spacing: 0.1em"
                                                    @click="editForm(category)"
                                                    >
                                                    Edit
                                                    </button>
                                                    <button
                                                    type="button"
                                                    class="btn btn-danger text-uppercase ml-1"
                                                    style="letter-spacing: 0.1em"
                                                    @click="deleteCategory(category)"
                                                    >
                                                    Delete
                                                    </button>
                                                </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <pagination :links="categories.links"></pagination>
                            </div>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
            </div>
        </section>
    </admin-layout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";
export default {
    props: ["categories"],
    components: {
        AdminLayout,
        Pagination,
    },
    data() {
        return {
            editedIndex: -1,
            editMode: false,
            form: this.$inertia.form({
                id: "",
                name: "",
                description: "",
            }),
        }
    },
    computed: {
        checkMode() {
            return this.editMode === false ? this.createCategory : this.editCategory;
        },
        buttonText() {
            return this.editedIndex === -1 ? "Save" : "Update";
        }
    },
    methods: {
        createCategory(){
            this.form.post(this.route("admin.categories.store"), {
                onSuccess: () => {
                    this.form.reset();
                    Toast.fire({
                        icon: "success",
                        title: "New Category",
                    });
                },
            });
        },
        editForm(category) {
            this.editMode = true;
            this.editedIndex = this.categories.indexOf(category);
            this.form.name = category.name;
            this.form.description = category.description;
            this.form.id = category.id;
        },
        editCategory() {
            this.form.patch(
            this.route("admin.categories.update", this.form.id, this.form),
            {
                preserveScroll: true,
                onSuccess: () => {
                Toast.fire({
                    icon: "info",
                    title: this.form.name.toUpperCase() + " Updated!",
                });
                this.form.reset();
                },
            }
            );
        },
        deleteCategory(category) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                this.form.delete(this.route("admin.categories.destroy", category), {
                    preserveScroll: true,
                    onSuccess: () => {
                    this.form.reset();
                    Swal.fire({
                        title: "Deleted!",
                        text: "Category deleted.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    },
                });
                }
            });
        },
    }
}
</script>
