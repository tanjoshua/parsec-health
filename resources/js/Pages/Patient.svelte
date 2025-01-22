<script lang="ts">
	import TenantLayout from "@/Layouts/TenantLayout.svelte";
	import * as Breadcrumb from "@/components/ui/breadcrumb";
	import type { Customer } from "@/types/customer";
	import type { Tenant } from "@/types/tenant";

	let {
		tenant,
		customer,
	}: {
		tenant: Tenant;
		customer: Customer;
	} = $props();
</script>

<svelte:head>
	<title>Patient | Parsec Health</title>
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
				<Breadcrumb.Item class="hidden md:block">
					<Breadcrumb.Link
						href={route("tenants.patients.index", tenant)}
						>Patients</Breadcrumb.Link
					>
				</Breadcrumb.Item>
				<Breadcrumb.Separator class="hidden md:block" />
				<Breadcrumb.Item>
					<Breadcrumb.Page>{customer.name}</Breadcrumb.Page>
				</Breadcrumb.Item>
			</Breadcrumb.List>
		</Breadcrumb.Root>
	{/snippet}
	<div class="container mx-auto p-4 space-y-8">
		<div>
			<h2 class="text-2xl font-bold">{customer.name}</h2>
		</div>
	</div>
</TenantLayout>
