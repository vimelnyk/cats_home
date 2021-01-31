

const load = () => {
    console.log()
    const menuWithLogo = document.querySelector('#header-vm .et_pb_menu_inner_container.clearfix')
    const menu = document.querySelector('#header-vm .et_pb_menu__wrap');
    const rightImg = document.querySelector('#header-vm .et_pb_module.et_pb_image.et_pb_image_0_tb_header')
    const rightImgWrap = document.querySelector('#header-vm .et_pb_column.et_pb_column_1_4.et_pb_column_1_tb_header.et_pb_css_mix_blend_mode_passthrough.et-last-child')
    const menuWrap = document.querySelector('#header-vm .et_pb_column.et_pb_column_3_4.et_pb_column_0_tb_header.et_pb_css_mix_blend_mode_passthrough.et_pb_column--with-menu')
    menuWithLogo.appendChild(rightImg)
    rightImgWrap.remove();
    menuWrap.style.width = '100%';
    console.log()
    menu.classList.add('visible');
    rightImg.classList.add('visible');
}


      
window.onload = load;