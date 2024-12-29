export type Visit = {
    patient: {
        id: string;
        tenant_patient_number: number;
        name: string;
    };
    registered_at: string;
    left_at?: string;
    remarks?: string;
    notes?: string;
    created_at: string;
    updated_at: string;
}; 