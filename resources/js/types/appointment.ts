export type Appointment = {
    start_time: string;
    end_time: string;

    patient_id?: string;
    patient_name?: string;

    remarks?: string;
    notes?: string;
    created_at: string;
    updated_at: string;
}