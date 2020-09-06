<template>
  <modal name="addNewProject">
    <div class="p-3">
        <h2 class="text-center">Let's start a project</h2>
        <!-- form -->
        <form @submit.prevent="submit" method="POST">
            <div class="row">
                <!-- left -->
                <div class="col-6">
                    <div class="form-group">
                        <label for="projectTitle">Title</label>
                        <input 
                            v-model="form.title" 
                            name="title" 
                            type="text" 
                            class="form-control"
                            :class="errors.title ? 'error-input' : ''" 
                            id="projectTitle" 
                            placeholder="Project title"
                        >
                        <small v-if="errors.title" class="form-text text-danger" v-text="errors.title[0]"></small>
                    </div>
                    <div class="form-group">
                        <label for="projectDescription">Description</label>
                        <textarea 
                            v-model="form.description" 
                            name="description" 
                            id="projectDescription" 
                            class="form-control"
                            :class="errors.description ? 'error-input' : ''"
                        >
                        </textarea>
                        <small v-if="errors.description" class="form-text text-danger" v-text="errors.description[0]"></small>
                    </div>
                </div>
                <!-- right -->
                <div class="col-6">
                    <!-- task list -->
                    <div class="form-group">
                        <label>Need some tasks?</label>
                        <input 
                            v-for="task in form.tasks" 
                            name="task" type="text" 
                            class="form-control mb-2" 
                            placeholder="A task"
                            v-bind:key="form.tasks.indexOf(task)"
                            v-model="task.value"
                        >
                    </div>
                    <!-- add task -->
                    <button @click="addOneTask" class="btn">+ One more task</button>
                </div>
            </div>

            <div class="text-right">
                <button @click.prevent="$modal.hide('addNewProject')" class="btn btn-info">Cancel</button>
                <button type="submit" class="btn btn-info">Create Project</button>
            </div>
        </form>
        <!-- end of form -->
    </div>
  </modal>
</template>

<script>
export default {
    data() {
        return {
            form: {
                title: '',
                description: '',
                tasks: [
                    { value: '' },
                ]
            },
            errors: []
        }
    },
    methods: {
        addOneTask() {
            this.form.tasks.push({ value: '' });
        },
        async submit() {
            try {
                const response = await axios.post('/projects', this.form);
                location = response.data.message;
            } catch (error) {
                this.errors = error.response.data.errors;
            }
        }
    }
}
</script>


