# Windows


## Boot Management

- Boot order: [Bios] > [Boot Order Selection] > [Primary HDD] > Master Boot Record > Boot loader > Specified OS

**Master Boot Record (MBR)**
- First sector on Harddrive, 512 bytes
- 446 bytes boot loader
- 64 bytes partition table (list of primary/extended partitions)

**Linux/Windows Bootloaders**
- Linux can only be started by GRUB
- Windows can only be started by Windows bootloader

----------------

### Fixing your MBR


#### Case 1: Erase/Reset MBR
- Boot from Windows Boot Stick
- Click "Repair Computer"
- Select "Troubleshooting" > "Advanced Options" > "Command Prompt"

**delete all partitions**
- `diskpart`
- `list disk` list disks
- `sel disk 0` (select hd by number)
- `list part` list partitions
- `sel part 1` select partition 1
- `del part override` delete this partition

--------------------
### Dual Boot: Win + Linux
- Bootloader: Grub. Load Linux or Windows bootloader

#### Windows Installtion
- First install Windows as usual

#### Ubuntu installation

- Install Linux: Select "Other installation type"

**Partitioning**
1. Create new partition with ~RAM size, select "use as swap" (for memory swapping)
2. Create new partition for filesystem (kernel, boot files, system files, libraries etc), mount at `/`, use `Ext4` formating
3. Create new partition for `/home` using `Ext4` formating
4. select drive and click "install now"


- - Select your drive to install the bootloader GRUB on
- Select your drive to install linux on (format as EXFAT4)


