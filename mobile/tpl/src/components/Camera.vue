<template>
<div id="camera">
  <v-row no-gutters>
    <v-col cols="12" class="d-flex justify-center">
      <v-btn block class="white--text" :class="{ 'orange lighten-1' : !isCameraOpen, 'red lighten-1' : isCameraOpen}" @click="toggleCamera">
        <span v-if="!isCameraOpen">Scan Qr</span>
        <span v-else>Tutup Kamera</span>
      </v-btn>
    </v-col>
    <v-col cols="12" class="d-flex justify-center">
      <div v-show="isCameraOpen && isLoading" class="my-5">
        <span class="black--text font-weight-bold">Membuka Kamera</span>
      </div>
    </v-col>
    <v-col cols="12">
      <div v-if="isCameraOpen" v-show="!isLoading" class="camera-box mt-5" :class="{ 'flash' : isShotPhoto }">
        <div class="camera-shutter" :class="{'flash' : isShotPhoto}"></div>
        <video v-show="!isPhotoTaken" ref="camera" autoplay class="bt-camera"></video>
        <canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" class="bt-photo-camera"></canvas>
      </div>
    </v-col>
    <!-- <v-col cols="12" v-if="isCameraOpen && !isLoading" class="d-flex justify-center">
      <v-btn block class="green lighten-1" @click="takePhoto">
        <v-icon color="white">mdi-camera</v-icon>
      </v-btn>
    </v-col>
    <v-col cols="12">
      <div v-if="isPhotoTaken && isCameraOpen" class="camera-download">
        <a id="downloadPhoto" download="my-photo.jpg" class="button" role="button" @click="downloadImage">
          Download
        </a>
      </div>
    </v-col> -->
  </v-row>
</div>
</template>

<script>
export default {
  data() {
    return {
      isCameraOpen: false,
      isPhotoTaken: false,
      isShotPhoto: false,
      isLoading: false,
      link: '#'
    }
  },

  methods: {
    toggleCamera() {
      if (this.isCameraOpen) {
        this.isCameraOpen = false;
        this.isPhotoTaken = false;
        this.isShotPhoto = false;
        this.stopCameraStream();
      } else {
        this.isCameraOpen = true;
        this.createCameraElement();
      }
    },

    createCameraElement() {
      this.isLoading = true;

      const constraints = (window.constraints = {
        audio: false,
        video: true
      });

      navigator.mediaDevices
        .getUserMedia(constraints)
        .then(stream => {
          this.isLoading = false;
          this.$refs.camera.srcObject = stream;
        })
        .catch(() => {
          this.isLoading = false;
          alert("May the browser didn't support or there is some errors.");
        });
    },

    stopCameraStream() {
      let tracks = this.$refs.camera.srcObject.getTracks();

      tracks.forEach(track => {
        track.stop();
      });
    },

    takePhoto() {
      if (!this.isPhotoTaken) {
        this.isShotPhoto = true;

        const FLASH_TIMEOUT = 50;

        setTimeout(() => {
          this.isShotPhoto = false;
        }, FLASH_TIMEOUT);
      }

      this.isPhotoTaken = !this.isPhotoTaken;

      const context = this.$refs.canvas.getContext('2d');
      context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);
    },

    downloadImage() {
      const download = document.getElementById("downloadPhoto");
      const canvas = document.getElementById("photoTaken").toDataURL("image/jpeg")
        .replace("image/jpeg", "image/octet-stream");
      download.setAttribute("href", canvas);
    }
  }
}
</script>