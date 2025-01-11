<script lang="ts">
	import PatientTable from "@/components/patients/patient-table.svelte";
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import type { PaginatedResult } from "@/types/pagination";
	import type { Patient } from "@/types/patient";
	import type { Tenant } from "@/types/tenant";

	let {
		patients,
		search,
		pageSize,
		tenant,
	}: {
		patients: PaginatedResult<Patient>;
		search: string;
		pageSize: number;
		tenant: Tenant;
	} = $props();
</script>

<svelte:head>
	<title>Patients | Parsec Health</title>
</svelte:head>

<TenantLayout>
	{#snippet breadcrumbs()}
		<Breadcrumb.Root>
			<Breadcrumb.List>
				<Breadcrumb.Item class="hidden md:block">
					<Breadcrumb.Link href={route("tenants.dashboard", tenant)}
						>{tenant.name}</Breadcrumb.Link
					>
				</Breadcrumb.Item>
				<Breadcrumb.Separator class="hidden md:block" />
				<Breadcrumb.Item>
					<Breadcrumb.Page>Patients</Breadcrumb.Page>
				</Breadcrumb.Item>
			</Breadcrumb.List>
		</Breadcrumb.Root>
	{/snippet}
	<div class="container mx-auto p-4 space-y-8">
		<div>
			<h2 class="text-2xl font-bold">Patients</h2>
		</div>
		<div>
			<PatientTable {patients} {search} pageSize={pageSize.toString()} />
		</div>
	</div>
</TenantLayout>
