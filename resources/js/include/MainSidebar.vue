<template>
  <div>
    <div v-if="!$isMobile()">
			 <div class=" mt-3 mb-2">
        <img
      src="/assets/New/images/white-logo.png"
      class="widget-icon"
      />
      <iframe
      src="https://timesprayer.com/widgets.php?frame=1&amp;lang=en&amp;name=new-york&amp;avachang=true&amp;time=0"
      style="border: none; overflow: hidden; width: 100%; height: 182px;border-radius: 6px;background: transparent;"
      ></iframe>
       </div>
     <!--  <div class=" border-green b-radius  mt-3 mb-2">
        <h4 class="text-center  mb-0 green-heading bt-radius">NAMAZ TIMINGS</h4>

        <div class="p-2">
          <p class="text-center mb-0 p-01  " v-if="mainData != ''">
            {{ mainData.namaz_timing.englishdate | namazDataFormat }}
          </p>

          <div
            style=" border: 1px solid #28a745;border-radius: 5px"
            class="mt-1"
          >
            <table
              class="tw widget-timming  table-striped p-0 mt-0"
              style=" overflow: hidden; "
            >
              <thead>
                <tr>
                  <th class="btn-success" width="50%">Prayer Name</th>
                  <th class="btn-success text-right" width="50%">Start Time</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Fajr</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.fajar }}
                  </td>
                </tr>
                <tr>
                  <td>Sunrise</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.sunrise }}
                  </td>
                </tr>
                <tr>
                  <td>Dhuhr</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.dhuhr }}
                  </td>
                </tr>
                <tr>
                  <td>Asr</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.asr }}
                  </td>
                </tr>
                <tr>
                  <td>Maghrib</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.maghrib }}
                  </td>
                </tr>
                <tr>
                  <td>Isha</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.isha }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div> -->

      <div class="border-green b-radius mt-3">
        <h4 class="text-center green-heading bt-radius mb-0">Use Full Links</h4>
        <div class="p-3">
          <div>
            <a
              href="javascript:;"
              class="hyperlink text-success"
              data-toggle="modal"
              data-target="#zukatModal"
              ><i class="fa fa-dot-circle"></i> Zakat Calculator</a
            >
          </div>

          <div>
            <router-link to="/99-name-of-allah" class="hyperlink text-success"
              ><i class="fa fa-dot-circle"></i> 99 Names of Allah</router-link
            >
          </div>

          <div>
            <router-link
              to="/ramadan-calendar-2021"
              class="hyperlink text-success"
              ><i class="fa fa-dot-circle"></i> Ramadan Calendar</router-link
            >
          </div>
        </div>
      </div>
      <div class="panel-display mb-5 mt-5 rounded"></div>
      <div class="border-green b-radius mt-3">
        <p
          class="bg-success text-center text-light rounded pt-2 pb-2 pl-3 pr-3"
        >
          Important Islamic Days<br />2020 (1441 - 1442 A.H)
        </p>
        <div class="p-3 pb-5">
          <table class="tw spacial_days_table">
            <tbody>
              <tr v-for="islamic_days in islamicdays">
                <td>{{ islamic_days.name }}</td>
                <td class="text-right">{{ islamic_days.start_date }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="col-sm-3">
        <div class=" border-green b-radius  mt-3 mb-2">
          <h4 class="text-center  mb-0 green-heading bt-radius">
            NAMAZ TIMINGS
          </h4>
          <!-- <div class="text-center">
        17th Dhul Hijjah, 1441h    </div> -->
          <div class="p-2">
            <p class="text-center mb-0 p-01  " v-if="mainData != ''">
            {{ mainData.namaz_timing.englishdate | namazDataFormat }}
          </p>

            <!-- tw  -->
            <div
              style=" border: 1px solid #28a745;border-radius: 5px"
              class="mt-1"
            >
              <table
                class="tw widget-timming  table-striped p-0 mt-0"
                style=" overflow: hidden; "
              >
                <thead>
                  <tr>
                    <th class="btn-success" width="50%">Prayer Name</th>
                    <th class="btn-success text-right" width="50%">
                      Start Time
                    </th>
                  </tr>
                </thead>
                  <tbody>
                <tr>
                  <td>Fajr</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.fajar }}
                  </td>
                </tr>
                <tr>
                  <td>Sunrise</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.sunrise }}
                  </td>
                </tr>
                <tr>
                  <td>Dhuhr</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.dhuhr }}
                  </td>
                </tr>
                <tr>
                  <td>Asr</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.asr }}
                  </td>
                </tr>
                <tr>
                  <td>Maghrib</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.maghrib }}
                  </td>
                </tr>
                <tr>
                  <td>Isha</td>
                  <td class="text-right" v-if="mainData != ''">
                    {{ mainData.namaz_timing.isha }}
                  </td>
                </tr>
              </tbody>
              </table>
            </div>
          </div>
        </div>

			
        <div class="border-green b-radius mt-3">
          <h4 class="text-center green-heading bt-radius mb-0">
            Use Full Links
          </h4>
          <div class="p-3">
            <div>
              <a
                href="javascript:;"
                class="hyperlink text-success"
                data-toggle="modal"
                data-target="#zukatModal"
                ><i class="fa fa-dot-circle"></i> Zakat Calculator</a
              >
            </div>
            <!-- <div><a href="javascript:;"class="hyperlink text-success"><i class="fa fa-dot-circle"></i> Events in UK</a></div><div><a href="javascript:;"class="hyperlink text-success"><i class="fa fa-dot-circle"></i> Social Distancing Mosques</a></div> -->
            <div>
              <router-link
                to="/99-name-of-allah"
                class="hyperlink text-success"
                ><i class="fa fa-dot-circle"></i> 99 Names of Allah</router-link>
            </div>
            <!--   <div><a href="http://localhost:8012/mosquefinder.co.uk/99-name-of-muhammad" class="hyperlink text-success"><i class="fa fa-dot-circle"></i> 99 Names of Muhammad</a></div> -->
            <div>
              <router-link
                to="/ramadan-calendar-2021"
                class="hyperlink text-success"
                ><i class="fa fa-dot-circle"></i> Ramadan Calendar</router-link>
            </div>
          </div>
        </div>
        <div class="panel-display mb-5 mt-5 rounded">
          <ins
            class="adsbygoogle"
            style="display:inline-block;width:100%;height:180px"
            data-ad-client="ca-pub-9682339330195266"
            data-ad-slot="9329871325"
            ><p
              class="panel-text text-success"
              onclick="scrollToBottomSocial(this)"
            >
              Install Our App To Calculate Zakat
            </p></ins
          >
          <!-- <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script> -->
        </div>

        <div class="border-green b-radius mt-3">
          <p class="bg-success text-center text-light rounded pt-2 pb-2 pl-3 pr-3">
            Important Islamic Days<br />2020 (1441 - 1442 A.H)
          </p>
          <div class="p-3 pb-5">
            <table class="tw spacial_days_table">
               <tbody>
              <tr v-for="islamic_days in islamicdays">
                <td>{{ islamic_days.name }}</td>
                <td class="text-right">{{ islamic_days.start_date }}</td>
              </tr>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
props: {
   mosqueSlug: String
 },
  data() {
    return {
      mainData: "",
      islamicdays: ""
    };
  },

  beforeMount() {
    this.getData();
  },

  methods: {
    getData() {
      var dataUrl = "v1/namaz-timing";
      axios({
        method: "GET",
        url: dataUrl,
        headers: { "content-type": "application/json" }
      }).then(
        result => {
          this.mainData = result.data.data;
          this.islamicdays = this.mainData.special_islamic_days;
        },
        error => {}
      );
    }
  }
};
</script>