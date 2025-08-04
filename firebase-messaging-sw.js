importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging.js');

firebase.initializeApp({
  apiKey: "AIzaSyDpqdO323gMKGpVJkDS40MQsE_4orF7FkY",
  authDomain: "smwi24.firebaseapp.com",
  projectId: "smwi24",
  messagingSenderId: "91288126447",
  appId: "1:91288126447:web:58f2cf21d3857fb7256c1a"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage(function(payload) {
  console.log('[firebase-messaging-sw.js] Background message ', payload);
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '../img/logo.png'
  };

  self.registration.showNotification(notificationTitle, notificationOptions);
});
