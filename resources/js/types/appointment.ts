export type Appointment = {
    id: string;
    start_time: string;
    end_time: string;

    customer_id?: string;
    customer_name?: string;

    remarks?: string;
    notes?: string;
    created_at: string;
    updated_at: string;
}