<template>
    <div class="item">
        <input
            type="checkbox"
            @change="updateCheck()"
            v-model="item.completed"/>
        <span :class="[item.completed ? 'completed' : '', 'item-text']">{{ item.name }}</span>
        <button @click="removeItem()" class="trashcan">
            <font-awesome-icon icon="trash"/>
        </button>
    </div>
</template>

<script>
export default {
    name: "listItem",
    props: ['item'],
    methods: {
        updateCheck: function () {
            axios.put(`api/items/${this.item.id}`, {
                item: this.item
            }).then(res => {
                if (res.status === 200) {
                    this.$emit('itemChanged')
                }
            }).catch(err => {
                console.log(err)
            })
        },
        removeItem: function () {
            axios.delete(`api/items/${this.item.id}`)
                .then(res => {
                    if (res.status === 200)
                        this.$emit('itemChanged')
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
}
</script>

<style scoped>
.completed {
    text-decoration: line-through;
    color: #999999;
}

.item-text {
    width: 100%;
    margin-left: 20px;
}

.item {
    display: flex;
    justify-content: center;
    align-items: center;
}

.trashcan {
    background: #e6e6e6;
    border: none;
    color: red;
    outline: none;
    cursor: pointer;
}
</style>
