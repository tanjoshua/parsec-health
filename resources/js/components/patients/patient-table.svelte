<script lang="ts">
	import { type ColumnDef, getCoreRowModel } from "@tanstack/table-core";
	import {
		createSvelteTable,
		FlexRender,
		renderComponent,
	} from "@/components/ui/data-table";
	import * as Table from "@/components/ui/table";
	import * as Select from "@/components/ui/select";
	import { Button } from "@/components/ui/button";
	import type { Patient } from "@/types/patient";
	import type { PaginatedResult } from "@/types/pagination";
	import PatientTableActions from "./patient-table-actions.svelte";
	import {
		ChevronLeft,
		ChevronRight,
		ChevronsLeft,
		ChevronsRight,
	} from "lucide-svelte";
	import { Input } from "../ui/input";
	import { useForm } from "@inertiajs/svelte";
	import SearchInput from "../ui/input/search-input.svelte";

	let {
		patients,
		search,
		pageSize,
	}: {
		patients: PaginatedResult<Patient>;
		search: string;
		pageSize: number;
	} = $props();

	console.log(patients);
	const columns: ColumnDef<Patient>[] = [
		{
			accessorKey: "tenant_patient_number",
			header: "Patient Number",
		},
		{
			accessorKey: "name",
			header: "Patient Name",
		},
		{
			accessorKey: "date_of_birth",
			header: "Date of Birth",
		},
		{
			id: "actions",
			cell: ({ row }) => {
				return renderComponent(PatientTableActions, {
					id: row.original.id.toString(),
				});
			},
		},
	];

	const table = createSvelteTable({
		get data() {
			return patients.data;
		},
		columns,
		getCoreRowModel: getCoreRowModel(),
	});

	const form = useForm({
		search: search,
	});

	const onSearch = (e: SubmitEvent) => {
		e.preventDefault();
		$form.get("");
	};
</script>

<div class="mb-4 flex justify-between">
	<form onsubmit={onSearch}>
		<SearchInput
			name="search"
			type="search"
			placeholder="Search Patients"
			class="max-w-xs"
			bind:value={$form.search}
			onCancel={() => {
				$form.search = "";
				$form.get("");
			}}
		/>
	</form>
</div>

<div class="rounded-md border">
	<Table.Root>
		<Table.Header>
			{#each table.getHeaderGroups() as headerGroup (headerGroup.id)}
				<Table.Row>
					{#each headerGroup.headers as header (header.id)}
						<Table.Head>
							{#if !header.isPlaceholder}
								<FlexRender
									content={header.column.columnDef.header}
									context={header.getContext()}
								/>
							{/if}
						</Table.Head>
					{/each}
				</Table.Row>
			{/each}
		</Table.Header>
		<Table.Body>
			{#each table.getRowModel().rows as row (row.id)}
				<Table.Row data-state={row.getIsSelected() && "selected"}>
					{#each row.getVisibleCells() as cell (cell.id)}
						<Table.Cell>
							<FlexRender
								content={cell.column.columnDef.cell}
								context={cell.getContext()}
							/>
						</Table.Cell>
					{/each}
				</Table.Row>
			{:else}
				<Table.Row>
					<Table.Cell
						colspan={columns.length}
						class="h-24 text-center"
					>
						No results.
					</Table.Cell>
				</Table.Row>
			{/each}
		</Table.Body>
	</Table.Root>
</div>

<div class="flex items-center justify-between mt-4">
	<div class="text-muted-foreground flex-1 text-sm">
		<!-- {Object.keys($selectedDataIds).length} of {$rows.length} row(s) selected. -->
	</div>
	<div class="flex items-center space-x-6 lg:space-x-8">
		<div class="flex items-center space-x-2">
			<p class="text-sm font-medium">Rows per page</p>
			<Select.Root
				type="single"
				name="pageSize"
				disabled
				value={pageSize.toString()}
			>
				<Select.Trigger class="h-8 w-[70px]">{pageSize}</Select.Trigger>
				<Select.Content>
					<Select.Item value="10">10</Select.Item>
					<Select.Item value="20">20</Select.Item>
					<Select.Item value="30">30</Select.Item>
					<Select.Item value="40">40</Select.Item>
					<Select.Item value="50">50</Select.Item>
				</Select.Content>
			</Select.Root>
		</div>
		<div
			class="flex w-[100px] items-center justify-center text-sm font-medium"
		>
			Page {patients.current_page} of {patients.last_page}
		</div>
		<div class="flex items-center space-x-2">
			<Button
				variant="outline"
				class="hidden h-8 w-8 lg:flex"
				disabled={!patients.prev_page_url}
				href={patients.prev_page_url ? patients.first_page_url : ""}
			>
				<span class="sr-only">Go to first page</span>
				<ChevronsLeft size={16} />
			</Button>
			<Button
				variant="outline"
				class="h-8 w-8"
				disabled={!patients.prev_page_url}
				href={patients.prev_page_url ? patients.prev_page_url : ""}
			>
				<span class="sr-only">Go to previous page</span>
				<ChevronLeft size={16} />
			</Button>
			<Button
				variant="outline"
				class="h-8 w-8"
				disabled={!patients.next_page_url}
				href={patients.next_page_url ? patients.next_page_url : ""}
			>
				<span class="sr-only">Go to next page</span>
				<ChevronRight size={16} />
			</Button>
			<Button
				variant="outline"
				class="hidden h-8 w-8 lg:flex"
				disabled={!patients.next_page_url}
				href={patients.next_page_url ? patients.last_page_url : ""}
			>
				<span class="sr-only">Go to last page</span>
				<ChevronsRight size={16} />
			</Button>
		</div>
	</div>
</div>
