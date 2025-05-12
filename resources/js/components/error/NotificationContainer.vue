<template>
    <Notification
      :show="notification.show"
      :type="notification.type"
      :title="notification.title"
      :message="notification.message"
      :dismissible="true"
      :duration="notification.duration"
      :position="notification.position"
      :action="notification.action"
      :actionText="notification.actionText"
      @dismiss="hideNotification"
      @action="triggerAction"
    />
  </template>
  
  <script setup>
  import Notification from './notification.vue';
  import { notification, hideNotification, triggerAction }  from '@/stores/notificationStore';
  </script>