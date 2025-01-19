export type Visit = {
    id: number;
    customer: {
        id: string;
        tenant_customer_number: number;
        name: string;
    };
    registered_at: string;
    left_at?: string;
    remarks?: string;
    notes?: string;
    created_at: string;
    updated_at: string;
}; 