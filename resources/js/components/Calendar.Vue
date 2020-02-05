<template>
    <div class="pt-3 container-fluid">
        <div class="holiday"></div>
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="m-1 btn btn-success" @click="addModal">
                                <i class="material-icons">add</i> Add Event
                            </button>
                            <button type="button" class="m-1 btn btn-success" @click="editModal">
                                <i class="material-icons">event</i> Event List
                            </button>
                        </div>
                        <div id="calendar"></div>
                    </div>

                    <form @submit.prevent="!editMode && mode === 'Update' ?  updateEvent() : addEvent()">
                        <div class="modal fade bd-example-modal-lg" id="Modal" tabindex="-1" role="dialog"
                            aria-labelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" v-show="!editMode && mode === 'Add'">New Event</h5>
                                        <h5 class="modal-title" v-show="!editMode && mode === 'Update'">Update Event</h5>
                                        <h5 class="modal-title" v-show="editMode && mode ==='Event'">Event List</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div v-show="!editMode" class="modal-body row">
                                        <div class="col-md-6">
                                            <div class="form-group" :class="{ 'form-group--error': $v.event.title.$error }">
                                                <label for="title" class="form__label">Event Title</label>
                                                <input type="text" class="form-control form__input" name="title"
                                                    v-model="event.title" v-model.trim="$v.event.title.$model"
                                                    placeholder="Enter Event Title">
                                            </div>
                                            <div class="error" v-if="!$v.event.title.required">Event Title is
                                                required</div>
                                            <div class="form-group" :class="{ 'form-group--error': $v.event.color.$error }">
                                                <label for="color" class="form__label">Event Color</label>
                                                <div class="row">
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-indigo"
                                                            @click="setEventColor('#6574cd')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-purple"
                                                            @click="setEventColor('#9561e2')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-pink"
                                                            @click="setEventColor('#f66D9b')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-red"
                                                            @click="setEventColor('#e3342f')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-orange"
                                                            @click="setEventColor('#f6993f')"></button></div>
                                                </div><br>
                                                <div class="row">
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-yellow"
                                                            @click="setEventColor('#ffed4a')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-teal"
                                                            @click="setEventColor('#4dc0b5')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-cyan"
                                                            @click="setEventColor('#6cb2eb')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-gray"
                                                            @click="setEventColor('#474747')"></button></div>
                                                    <div class="col-md-1 ml-2 mr-2"><button type="button" class="btn pallete pallete-black"
                                                            @click="setEventColor('#383b50')"></button></div>
                                                </div>
                                                <div class="form-group form-inline p-2"><br>
                                                    <label class="p-2">Selected Color:</label>
                                                    <button type="button" class="btn pallete" :style="{background: event.color}"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="error" v-if="!$v.event.color.required">Event Color is
                                            required</div>
                                        <div class="col-md-6">


                                            <div class="form-group" :class="{ 'form-group--error': $v.event.start_date.$error }">
                                                <label for="color" class="form__label">Start Date of the Event</label>
                                                <datepicker class="form-calendar form__input" v-model="event.start_date"
                                                    v-model.trim="$v.event.start_date.$model" :disabled-dates="disabledPastDates"
                                                    :format="'MMM. dd, yyyy'" placeholder="Click Here to Choose a Date"
                                                    @input="convertStartDate()"></datepicker>
                                            </div>
                                            <div class="error" v-if="!$v.event.start_date.required">Start Date of
                                                the Event is required</div>
                                            <div class="form-group" :class="{ 'form-group--error': $v.event.end_date.$error }">
                                                <label for="color" class="form__label">End Date of the Event</label>
                                                <datepicker class="form-calendar form__input" v-model="event.end_date"
                                                    v-model.trim="$v.event.end_date.$model" :disabled-dates="disabledPastDates"
                                                    :format="'MMM. dd, yyyy'" placeholder="Click Here to Choose a Date"
                                                    @input="convertEndDate()"></datepicker>
                                            </div>
                                            <div class="error" v-if="!$v.event.end_date.required">End Date of the
                                                Event is required</div>
                                        </div>

                                    </div>



                                    <div v-show="editMode" class="modal-body row">
                                        <div v-show="events.length !== 0" class="container">
                                            <table class="table table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Color</th>
                                                        <th scope="col">Start Date</th>
                                                        <th scope="col">End Date</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-for="(event, index) in events" :key="event.id">
                                                    <tr>
                                                        <th scope="row">{{ index + 1 }}</th>
                                                        <td>{{ event.title }}</td>
                                                        <td><button type="button" class="btn pallete" :style="{background: event.color}"></button></td>
                                                        <td>{{ event.start_date }}</td>
                                                        <td>{{ event.end_date }}</td>
                                                        <td v-if="event.case_no === null">
                                                            <button type="button" class="btn btn-primary" @click="editEvent(event)"><i
                                                                    class="material-icons">edit</i></button>
                                                            <button type="button" class="btn btn-danger" @click="deleteEvent(event.id)"><i
                                                                    class="material-icons">delete</i></button>
                                                        </td>
                                                        <td v-if="event.case_no !== null">
                                                            <small>No Actions for Hearing Event</small>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div v-show="events.length === 0" class="container text-center">
                                            <h3>No Event/s</h3><br>
                                            <h5>Do you wish to add an event?</h5>
                                            <button type="button" @click="editMode = false; mode = 'Add'" class="btn btn-success">Add
                                                Event</button>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="resetModal">Close</button>
                                        <button v-show="!editMode && mode === 'Add'" type="submit" class="btn btn-success">Add
                                            Event</button>
                                        <button v-show="!editMode && mode === 'Update'" type="button" class="btn btn-secondary"
                                            @click="editMode = true; mode = 'Event'">Back</button>
                                        <button v-show="!editMode && mode === 'Update'" type="submit" class="btn btn-primary">Update
                                            Event</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {
        required
    } from 'vuelidate/lib/validators';
    import * as $ from 'jquery';
    import 'fullcalendar';
    import Datepicker from 'vuejs-datepicker';
    export default {
        components: {
            Datepicker
        },
        data() {
            return {
                disabledPastDates: {
                    to: new Date(Date.now() - 8640000)
                },
                mode: '',
                holiday: [],
                holidayObj: [],
                editMode: false,
                events: {},
                event: new Form({
                    id: '',
                    title: '',
                    color: '#6574cd',
                    start_date: '',
                    end_date: '',
                    case_no: ''
                })
            }
        },
        validations: {
            event: {
                title: {
                    required
                },
                color: {
                    required
                },
                start_date: {
                    required
                },
                end_date: {
                    required
                },
            }
        },
        methods: {
            convertStartDate() {
                let tomorrow = new Date(window.moment(this.event.start_date))
                let start = window.moment(this.event.start_date).format('YYYY-MM-DD')
                this.disabledPastDates.to = tomorrow
                this.event.start_date = start

            },
            convertEndDate() {
                this.event.end_date = window.moment(this.event.end_date).format('YYYY-MM-DD')
            },
            loadEvents() {
                axios.get('api/calendar').then(({
                    data
                }) => {
                    this.events = data
                    $(() => {
                        let eventsArr = []
                        for (let i in data) {
                            eventsArr.push({
                                title: data[i].title,
                                start: data[i].start_date,
                                end: data[i].end_date,
                                color: data[i].color,
                                case_no: data[i].case_no,
                                control_num: data[i].control_num,
                                isAllDay: false
                            })
                        }
                        let containerEl = $('#calendar');
                        containerEl.fullCalendar({
                            themeSystem: 'bootstrap4',
                            header: {
                                right: 'prev,next',
                                center: 'title',
                                left: 'today'
                            },
                            events: eventsArr.concat(this.holidayObj),
                            eventLimit: true,
                            displayEventEnd: true,
                            eventRender: (eventObj, $el) => {
                                $el.popover({
                                    content: eventObj.title,
                                    trigger: 'hover',
                                    placement: 'bottom',
                                })

                            },
                            eventClick: (calEvent, jsEvent, view) => {
                                window.location.href = 'cases/' + calEvent.control_num
                            },
                            displayEventTime: false
                        })


                    })
                })
            },
            addModal() {
                this.mode = 'Add'
                this.editMode = false
                this.event.reset()
                $('#Modal').modal('show')
            },
            editModal() {
                this.editMode = true
                this.mode = 'Event'
                $('#Modal').modal('show')
            },
            editEvent(event) {
                this.editMode = false
                this.mode = 'Update'
                this.event.fill(event)
            },
            resetModal() {
                this.event.reset()
            },
            deleteEvent(id) {
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.event.delete('api/calendar/' + id).then(() => {
                            swal(
                                'Deleted!',
                                'The event has been deleted.',
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }).catch(() => {
                            swal('Failed!', 'There was something wrong.', 'warning')
                        });
                    }
                })
            },
            updateEvent() {
                this.$Progress.start();
                this.event.put('api/calendar/' + this.event.id).then(() => {
                    $('#Modal').modal('hide')
                    swal(
                        'Updated!',
                        'The selected event has been updated.',
                        'success'
                    )
                    this.$Progress.finish()
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }).catch(() => {
                    this.$Progress.fail()
                });
            },
            setEventColor(colorPallete) {
                this.event.color = colorPallete
            },
            addEvent() {
                this.$Progress.start()
                this.$v.event.$touch()
                if (this.$v.event.$invalid) {
                    this.$Progress.fail()
                } else {
                    this.event.post('api/calendar').then(() => {
                        toast({
                            type: 'success',
                            title: 'Event Added Successfully.'
                        })
                        this.$Progress.finish()
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                        $('#Modal').modal('hide')
                    }).catch(() => {
                        this.$Progress.fail()
                    })
                }
            },
        },
        mounted() {
            this.loadEvents()
            Fire.$on('Refresh', () => {
                this.loadEvents()
            });


            if (new Date().getFullYear() === 2019) {
                $.getJSON('./holiday-2019.json').then((data) => {
                    this.holiday = data
                    for (let i = 0; i < data.length; i++) {
                        this.holiday[i].Date = new Date(this.holiday[i].Date)
                        this.holiday[i].Date = this.holiday[i].Date.setFullYear(2019)
                        this.holiday[i].Date = new Date(this.holiday[i].Date)
                        this.holidayObj.push({
                            'title': this.holiday[i].Holiday,
                            'start': this.holiday[i].Date
                        })
                    }
                })
            }


            Fire.$on('searching', () => {
                let query = this.$parent.search
                axios.get('api/findUser?val=' + query).then((data) => {
                    this.$parent.searchResults = data.data
                }).catch(() => {
                    this.$Progress.fail()
                })
            })
        }
    }

</script>
