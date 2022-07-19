import { mdiTicket, mdiAccountMultiple, mdiHospitalBox } from '@mdi/js';

export default [
  'General',
  [
    {
      route: 'tickets.index',
      icon: mdiTicket,
      label: 'Tickets',
      type: 'normal'
    },
    {
      route: 'tickets.index',
      icon: mdiTicket,
      label: 'Tickets',
      type: 'admin'
    },
    {
      route: 'patients.index',
      icon: mdiAccountMultiple,
      label: 'Patients',
      type: 'normal'
    },
    {
      route: 'patients.index',
      icon: mdiAccountMultiple,
      label: 'Patients',
      type: 'admin'
    },
    {
      route: 'doctors.index',
      icon: mdiHospitalBox,
      label: 'Doctors',
      type: 'admin'
    },

    {
      route: 'departments.index',
      icon: mdiHospitalBox,
      label: 'Departments',
      type: 'admin'
    }
  ]
];
