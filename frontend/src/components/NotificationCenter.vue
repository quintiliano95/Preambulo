<template>
  <div class="notification-container">
    <div v-for="notification in notifications" 
         :key="notification.id"
         :class="['notification', notification.type]"
         @click="removeNotification(notification.id)">
      {{ notification.message }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotificationCenter',
  props: {
    notifications: {
      type: Array,
      required: true
    }
  },
  methods: {
    removeNotification(id) {
      this.$emit('remove-notification', id)
    }
  }
}
</script>

<style scoped>
.notification-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
}

.notification {
  padding: 1rem 1.5rem;
  margin-bottom: 0.5rem;
  border-radius: 4px;
  color: white;
  cursor: pointer;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  animation: slideIn 0.3s ease-out;
}

.notification.success {
  background-color: #42b983;
}

.notification.error {
  background-color: #e74c3c;
}

.notification.warning {
  background-color: #f39c12;
}

@keyframes slideIn {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}
</style>