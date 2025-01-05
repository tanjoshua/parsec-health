<script lang="ts">
    import Calendar from "lucide-svelte/icons/calendar";
    import House from "lucide-svelte/icons/house";
    import Inbox from "lucide-svelte/icons/inbox";
    import * as Sidebar from "@/components/ui/sidebar";
    import type { Tenant } from "@/types/tenant";
    import { Users } from "lucide-svelte";
    import { page } from "@inertiajs/svelte";

    let props = $props<{ tenant: Tenant }>();

    // Menu items.
    const items = [
        {
            title: "Dashboard",
            url: `/tenants/${props.tenant.id}`,
            icon: House,
            isActive: $page.url === `/tenants/${props.tenant.id}`,
        },
        {
            title: "Visits",
            url: `/tenants/${props.tenant.id}/visits`,
            icon: Inbox,
            isActive: $page.url === `/tenants/${props.tenant.id}/visits`,
        },
        {
            title: "Appointments",
            url: `/tenants/${props.tenant.id}/appointments`,
            icon: Calendar,
            isActive: $page.url === `/tenants/${props.tenant.id}/appointments`,
        },
        {
            title: "Patients",
            url: `/tenants/${props.tenant.id}/patients`,
            icon: Users,
            isActive: $page.url === `/tenants/${props.tenant.id}/patients`,
        },
    ];
</script>

<Sidebar.Root>
    <Sidebar.Content>
        <Sidebar.Group>
            <Sidebar.GroupLabel>{props.tenant.name}</Sidebar.GroupLabel>
            <Sidebar.GroupContent>
                <Sidebar.Menu>
                    {#each items as item (item.title)}
                        <Sidebar.MenuItem>
                            <Sidebar.MenuButton isActive={item.isActive}>
                                {#snippet child({ props })}
                                    <a href={item.url} {...props}>
                                        <item.icon />
                                        <span>{item.title}</span>
                                    </a>
                                {/snippet}
                            </Sidebar.MenuButton>
                        </Sidebar.MenuItem>
                    {/each}
                </Sidebar.Menu>
            </Sidebar.GroupContent>
        </Sidebar.Group>
    </Sidebar.Content>
</Sidebar.Root>
