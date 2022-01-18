export const UsersComponent = {
    template : `
    <div id="userList">
        <ul>
            <li v-for="(user, index) in users" :key="index">
                {{ user.name }} ||
                <button @click="$emit('edit-user', index)">Edit</button>
                <button @click="$emit('delete-user', index)">Delete</button>
            </li>
        </ul>
    </div>`,
    props : [
        'users'
    ]
}
