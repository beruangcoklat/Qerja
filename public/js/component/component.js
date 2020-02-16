Vue.component('company-info-gaji', {
    props : ['data'],
    template : `
        <div class="info-gaji-item">
            <div>
                <div>
                    <img v-bind:src="'image/company/' + data.CompanyImage">
                </div>
                <div class="info-gaji-item-name">
                    <p>{{ data.JobName }}</p>
                    <p>{{ data.CompanyName }}</p>
                </div>
            </div>
            <div>
                <p>Rata-Rata Gaji</p>
                <p>Rp {{ data.AverageSalary.toFixed(2) }}</p>
            </div>
            <div>
                <input type="range" disabled
                    v-bind:min="data.MinSalary"
                    v-bind:max="data.MaxSalary"
                    v-bind:value="data.AverageSalary"
                >
                <p>{{ data.MinSalary }} - {{ data.MaxSalary }}</p>
            </div>
        </div>
    `,
});


Vue.component('company-paginate', {
    props : ['data'],
    template : `
        <div class="paginate-item">
            <p>{{ data }}</p>
        </div>
    `,
});


Vue.component('chat-message', {
    props : ['data'],
    template : `
        <div class="chat-item" v-bind:class="{ right : data.isRight }">
            <div class="chat-item-container">
                <div class="chat-item-user">
                    <p>{{ data.name }}</p>
                </div>
                <div class="chat-item-message">
                    <p>{{ data.message }}</p>
                </div>
            </div>
        </div>
    `,
});

