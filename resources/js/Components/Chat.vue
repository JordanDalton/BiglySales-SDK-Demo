<script setup>

import { onMounted, ref, watch } from 'vue'

onMounted(() => {
  //
});

const started = ref(false);

const expanded = ref(false);

const messages = ref([]);

const question = ref('');

const thinking = ref(false);

const chatLog = ref(null);

const chatbot = ref({
  client_id         : '',
  auto_responder_id : '',
  chat_reference_id : '',
});

const startThinking = () => {
  thinking.value = true;
}

const stopThinking = () => {
  thinking.value = false;
}

const startChatSession = () => {

  startThinking()

  axios.post('api/start')
      .then(response => {
        chatbot.value.client_id         = response.data.client.id;
        chatbot.value.auto_responder_id = response.data.auto_responder.data.id;
        chatbot.value.chat_reference_id = response.data.chat_reference_id;
      })
      .catch(error => {
        stopThinking()
        alert('We were unable to process your requset.')
      });

}

const askQuestion = () => {

  if(question.value){

    let theQuestion = question.value;

    startThinking()

    messages.value.push({
      message : theQuestion,
      from    : 'user',
    });

    question.value = ''

    axios.post('/api/chat', {
      question          : theQuestion,
      client_id         : chatbot.value.client_id,
      auto_responder_id : chatbot.value.auto_responder_id,
      chat_reference_id : chatbot.value.chat_reference_id,
    }, {
      timeout: 1000 * 60
    }).then(response => {
      stopThinking()

      respondToQuestion(response.data.data.response);

    }).catch(error => {
      stopThinking()
      alert('We were unable to process your request.')
    });

  }

}

const respondToQuestion = (response) => {

  messages.value.push({
    message : response,
    from    : 'agent',
  });

}

watch(expanded, (value) => {

  if (value && !started.value) {

    startChatSession();

    setTimeout(() => {

      respondToQuestion('Hello, how can I help you today?');

      stopThinking()

    }, 1000);

    started.value = true
  }

});

watch(messages.value, () => {

  setTimeout(scrollToBottom, 400);
});

const scrollToBottom = () => {

  const chat = chatLog.value;
        chat.scrollTop = chat.scrollHeight;
}

const fromUser = (message) => {
  return message.from === 'user';
}

</script>

<template>
    <div>

      <button v-if="!expanded" @click="expanded = !expanded" class="bg-blue-500 hover:bg-blue-400 grid place-items-center p-4 rounded-full shadow-lg space-x-3 text-2xl text-white">
        <i class="fa-solid fa-headset"></i>
      </button>

      <div class="bg-white border-2 flex flex-col rounded-lg shadow-2xl h-[400px] w-[400px]" v-if="expanded">
        <div class="bg-blue-600 p-3 rounded-t-lg text-white">

          <div class="flex flex-row gap-3">
            <div>
              <!-- Extra Large -->
              <img
                  src="https://cdn.tailkit.com/media/placeholders/avatar-iFgRcqHznqg-160x160.jpg"
                  alt="User Avatar"
                  class="inline-block size-[60px] rounded-full"
              />
            </div>
            <div>
              <div class="text-3xl font-bold">Hello 👋</div>
              <div>We are here to help.</div>
            </div>
          </div>
          <div class="mt-2 text-xs">Average wait time: 20 seconds.</div>
        </div>
        <div ref="chatLog" id="chatLog" class="bg-gray-100 grow p-4 space-y-4 overflow-auto">

          <div class="flex flex-row space-x-3" v-for="message in messages">
            <div>
              <div :class="{ 'bg-blue-500': !fromUser(message), 'bg-green-500': fromUser(message), 'grid place-items-center rounded-full h-10 w-10 text-white' : true }">
                {{ message.from === 'user' ? 'You' : 'AI' }}
              </div>
            </div>
            <div class="bg-white p-3">{{ message.message }}</div>
          </div>

          <div v-if="thinking" class="grid place-items-center">
            <i class="fas fa-spinner fa-spin"></i>
          </div>

        </div>
        <div class="border-2 flex flex-row rounded-b-lg p-1">
          <input v-model.trim="question" @keydown.enter="askQuestion" class="border-0 grow" rows="1" placeholder="Enter message."/>
          <button @click="askQuestion" class="p-2 text-blue-500" :disabled="!question.length">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
        </div>
      </div>

    </div>
</template>

<style scoped>

button:disabled {
  @apply cursor-not-allowed opacity-50;
}

#chatLog {
  scroll-behavior: smooth;
}

</style>